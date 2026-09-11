<?php
require_once dirname(__DIR__, 2) . '/core/Model.php';

/**
 * OtpModel — Gestión de códigos OTP basados en email + SHA-256
 *
 * Tabla esperada:
 *   otp_codes (id, email, code_hash, type, attempts, status, expires_at, created_at)
 */
class OtpModel extends Model
{
    private const MAX_ATTEMPTS = 5;

    /**
     * Genera un OTP de 6 dígitos, invalida anteriores activos,
     * almacena el hash SHA-256 y retorna el código en texto plano
     * (para enviarlo por email).
     *
     * @param string $email Correo del usuario
     * @param string $type  'register' | 'login_psicologa'
     * @return string       Código de 6 dígitos en texto plano
     */
    public function generateOtp(string $email, string $type = 'register'): string
    {
        // 1. Generar código numérico seguro de 6 dígitos
        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);

        // 2. Hash SHA-256 (nunca se guarda en texto plano)
        $codeHash = hash('sha256', $codigo);

        // 3. Expiración: 10 minutos desde ahora
        $expiresAt = date('Y-m-d H:i:s', strtotime('+10 minutes'));

        // 4. Invalidar OTPs activos previos para este email y tipo
        $stmt = $this->db->prepare(
            "UPDATE otp_codes SET status = 'expired'
             WHERE email = ? AND type = ? AND status = 'active'"
        );
        $stmt->execute([$email, $type]);

        // 5. Insertar nuevo registro
        $stmt = $this->db->prepare(
            "INSERT INTO otp_codes (email, code_hash, type, attempts, status, expires_at)
             VALUES (?, ?, ?, 0, 'active', ?)"
        );
        $stmt->execute([$email, $codeHash, $type, $expiresAt]);

        return $codigo;
    }

    /**
     * Verifica un código OTP.
     *
     * Flujo:
     *   1. Busca OTP activo para el email/tipo
     *   2. Comprueba expiración
     *   3. Comprueba intentos
     *   4. Compara hash
     *   5. Marca como 'used' si es correcto; incrementa attempts si no
     *
     * @param string $email  Correo del usuario
     * @param string $codigo Código ingresado por el usuario
     * @param string $type   'register' | 'login_psicologa'
     * @return array{status: bool, message: string}
     */
    public function verifyOtp(string $email, string $codigo, string $type = 'register'): array
    {
        // 1. Buscar el OTP activo más reciente para este email y tipo
        $stmt = $this->db->prepare(
            "SELECT * FROM otp_codes
             WHERE email = ? AND type = ? AND status = 'active'
             ORDER BY id DESC LIMIT 1"
        );
        $stmt->execute([$email, $type]);
        $otp = $stmt->fetch();

        if (!$otp) {
            return [
                'status'  => false,
                'message' => 'No hay un código de verificación activo. Solicita uno nuevo.'
            ];
        }

        // 2. Verificar expiración
        if (strtotime($otp['expires_at']) < time()) {
            $stmtExpire = $this->db->prepare(
                "UPDATE otp_codes SET status = 'expired' WHERE id = ?"
            );
            $stmtExpire->execute([$otp['id']]);

            return [
                'status'  => false,
                'message' => 'El código ha expirado. Por favor, solicita uno nuevo.'
            ];
        }

        // 3. Verificar intentos máximos
        if ((int)$otp['attempts'] >= self::MAX_ATTEMPTS) {
            $stmtBlock = $this->db->prepare(
                "UPDATE otp_codes SET status = 'blocked' WHERE id = ?"
            );
            $stmtBlock->execute([$otp['id']]);

            return [
                'status'  => false,
                'message' => 'Demasiados intentos fallidos. Solicita un nuevo código.'
            ];
        }

        // 4. Comparar hash SHA-256
        $inputHash = hash('sha256', $codigo);

        if (!hash_equals($otp['code_hash'], $inputHash)) {
            // Incrementar contador de intentos
            $stmtAttempts = $this->db->prepare(
                "UPDATE otp_codes SET attempts = attempts + 1 WHERE id = ?"
            );
            $stmtAttempts->execute([$otp['id']]);

            $remaining = self::MAX_ATTEMPTS - (int)$otp['attempts'] - 1;
            return [
                'status'  => false,
                'message' => "Código incorrecto. Te quedan {$remaining} intento(s)."
            ];
        }

        // 5. Código correcto → marcar como usado y verificar usuario
        try {
            $this->db->beginTransaction();

            $stmtUsed = $this->db->prepare(
                "UPDATE otp_codes SET status = 'used' WHERE id = ?"
            );
            $stmtUsed->execute([$otp['id']]);

            // Marcar usuario como verificado en la tabla usuarios
            $stmtVerify = $this->db->prepare(
                "UPDATE usuarios SET verificado = 1 WHERE correo_electronico = ?"
            );
            $stmtVerify->execute([$email]);

            $this->db->commit();

            return [
                'status'  => true,
                'message' => 'Cuenta verificada correctamente.'
            ];
        } catch (\Exception $e) {
            $this->db->rollBack();
            error_log('[OtpModel] Error en verificación: ' . $e->getMessage());
            return [
                'status'  => false,
                'message' => 'Hubo un error interno al verificar. Intenta nuevamente.'
            ];
        }
    }
}
