<?php
require_once dirname(__DIR__, 2) . '/core/Model.php';

class OtpModel extends Model 
{
    /**
     * Genera un OTP de 6 dígitos aleatorio, lo guarda y retorna el código.
     */
    public function generateOtp(int $userId): string 
    {
        // 1. Generar código de 6 dígitos seguro
        $codigo = str_pad((string) random_int(0, 999999), 6, '0', STR_PAD_LEFT);
        
        // 2. Definir tiempo de expiración (10 minutos)
        $expiraEn = date('Y-m-d H:i:s', strtotime('+10 minutes'));
        
        // 3. Invalidar cualquier código anterior no usado de este usuario
        $stmt = $this->db->prepare("UPDATE otp_codes SET usado = 1 WHERE id_usuario = ? AND usado = 0");
        $stmt->execute([$userId]);
        
        // 4. Insertar el nuevo código
        $stmt = $this->db->prepare("INSERT INTO otp_codes (id_usuario, codigo, expira_en) VALUES (?, ?, ?)");
        $stmt->execute([$userId, $codigo, $expiraEn]);
        
        return $codigo;
    }

    /**
     * Verifica si el código es correcto, no ha expirado y marca al usuario como verificado.
     */
    public function verifyOtp(int $userId, string $codigo): array 
    {
        $stmt = $this->db->prepare(
            "SELECT * FROM otp_codes 
             WHERE id_usuario = ? AND codigo = ? AND usado = 0 
             ORDER BY id DESC LIMIT 1"
        );
        $stmt->execute([$userId, $codigo]);
        $otp = $stmt->fetch();

        if (!$otp) {
            return ['status' => false, 'message' => 'El código es incorrecto o ya fue utilizado.'];
        }

        if (strtotime($otp['expira_en']) < time()) {
            return ['status' => false, 'message' => 'El código ha expirado. Por favor, solicita uno nuevo.'];
        }

        try {
            $this->db->beginTransaction();

            $stmtUpdateOtp = $this->db->prepare("UPDATE otp_codes SET usado = 1 WHERE id = ?");
            $stmtUpdateOtp->execute([$otp['id']]);

            $stmtUpdateUser = $this->db->prepare("UPDATE usuarios SET verificado = 1 WHERE id_usuario = ?");
            $stmtUpdateUser->execute([$userId]);

            $this->db->commit();
            return ['status' => true, 'message' => 'Cuenta verificada correctamente.'];
            
        } catch (Exception $e) {
            $this->db->rollBack();
            return ['status' => false, 'message' => 'Hubo un error interno al verificar. Intenta nuevamente.'];
        }
    }
}
