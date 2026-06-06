<?php
/**
 * Modelo de Usuario
 *
 * Toda la lógica de acceso a datos de la tabla `usuarios`.
 * Las contraseñas se almacenan con password_hash() (bcrypt)
 * y se verifican con password_verify().
 *
 * Columnas reales (según psycoLomejor.sql):
 *   id_usuario, grado, nombre, correo_electronico, contrasena,
 *   acepta_politica, estado, fecha_registro, acudiente_nombre, 
 *   acudiente_cedula, acudiente_relacion, acudiente_correo
 */
class UserModel extends Model
{
    // ──────────────────────────────────────────────────────────────
    //  Lectura
    // ──────────────────────────────────────────────────────────────

    /** Devuelve todos los usuarios (sin contraseña) */
    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT id_usuario, grado, nombre, correo_electronico, estado, fecha_registro
             FROM usuarios
             ORDER BY fecha_registro DESC'
        );
        return $stmt->fetchAll();
    }

    /** Busca un usuario por su PK */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT id_usuario, grado, nombre, correo_electronico, estado, fecha_registro, avatar_url, google_id, acudiente_nombre, acudiente_cedula, acudiente_relacion, acudiente_correo
             FROM usuarios WHERE id_usuario = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Verifica credenciales y devuelve el usuario o null.
     * Soporta contraseñas almacenadas con password_hash().
     */
    public function findByCredentials(string $email, string $password): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM usuarios WHERE correo_electronico = :correo AND estado = "activo"'
        );
        $stmt->execute([':correo' => $email]);
        $row = $stmt->fetch();

        if ($row && password_verify($password, $row['contrasena'])) {
            return $row;
        }
        return null;
    }

    // ──────────────────────────────────────────────────────────────
    //  Escritura
    // ──────────────────────────────────────────────────────────────

    /**
     * Registra un nuevo usuario.
     *
     * @param string      $grado          Grado escolar (6-11)
     * @param string      $nombre         Nombre completo
     * @param string      $email          Correo electrónico
     * @param string      $password       Contraseña en texto plano (se hashea aquí)
     * @param string      $aceptaPolitica 'si' o 'no'
     * @param string      $nombreAcudiente
     * @param string      $cedulaAcudiente
     * @param string      $relacionAcudiente
     * @param string      $correoAcudiente
     * @return int  ID del usuario insertado
     */
    public function create(
        string $grado,
        string $nombre,
        string $email,
        string $password,
        string $aceptaPolitica = 'no',
        string $nombreAcudiente = '',
        string $cedulaAcudiente = '',
        string $relacionAcudiente = '',
        string $correoAcudiente = ''
    ): int {
        $hash    = password_hash($password, PASSWORD_BCRYPT);

        $sql = 'INSERT INTO usuarios
                    (grado, nombre, correo_electronico, contrasena, acepta_politica, acudiente_nombre, acudiente_cedula, acudiente_relacion, acudiente_correo)
                VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$grado, $nombre, $email, $hash, $aceptaPolitica, $nombreAcudiente, $cedulaAcudiente, $relacionAcudiente, $correoAcudiente]);

        return (int) $this->db->lastInsertId();
    }

    /** Comprueba si un correo ya está registrado */
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare(
            'SELECT COUNT(*) FROM usuarios WHERE correo_electronico = ?'
        );
        $stmt->execute([$email]);
        return (int) $stmt->fetchColumn() > 0;
    }

    // ──────────────────────────────────────────────────────────────
    //  Google OAuth
    // ──────────────────────────────────────────────────────────────

    /**
     * Busca un usuario por google_id o por correo electrónico.
     * Si no existe, retorna null.
     *
     * @param array $googleUser  Perfil devuelto por GoogleOAuthService::getUserInfo()
     *                           Campos esperados: sub, email, name, picture, email_verified
     * @return array|null  Fila completa del usuario en nuestra BD o null
     */
    public function findByGoogle(array $googleUser): ?array
    {
        $googleId  = $googleUser['sub']     ?? '';
        $email     = $googleUser['email']   ?? '';
        $avatar    = $googleUser['picture'] ?? null;

        // 1. Buscar por google_id (usuario que ya inició sesión antes con Google)
        if ($googleId) {
            $stmt = $this->db->prepare(
                'SELECT * FROM usuarios WHERE google_id = ? LIMIT 1'
            );
            $stmt->execute([$googleId]);
            $user = $stmt->fetch();
            if ($user) {
                // Actualizar avatar si cambió
                if ($avatar && $user['avatar_url'] !== $avatar) {
                    $this->db->prepare(
                        'UPDATE usuarios SET avatar_url = ? WHERE id_usuario = ?'
                    )->execute([$avatar, $user['id_usuario']]);
                    $user['avatar_url'] = $avatar;
                }
                return $user;
            }
        }

        // 2. Buscar por correo (usuario registrado manualmente antes)
        if ($email) {
            $stmt = $this->db->prepare(
                'SELECT * FROM usuarios WHERE correo_electronico = ? LIMIT 1'
            );
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user) {
                // Vincular google_id y avatar para futuros inicios de sesión
                $this->db->prepare(
                    'UPDATE usuarios SET google_id = ?, avatar_url = ? WHERE id_usuario = ?'
                )->execute([$googleId, $avatar, $user['id_usuario']]);
                $user['google_id']  = $googleId;
                $user['avatar_url'] = $avatar;
                return $user;
            }
        }

        // 3. No registrado
        return null;
    }
}
