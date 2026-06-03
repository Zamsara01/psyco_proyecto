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
 *   acepta_politica, datos_acudiente (JSON), estado, fecha_registro
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
            'SELECT id_usuario, grado, nombre, correo_electronico, estado, fecha_registro
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
     * @param array|null  $datosAcudiente Array con nombre, cedula, relacion (cuando acepta_politica = 'si')
     * @return int  ID del usuario insertado
     */
    public function create(
        string $grado,
        string $nombre,
        string $email,
        string $password,
        string $aceptaPolitica = 'no',
        ?array $datosAcudiente = null
    ): int {
        $hash    = password_hash($password, PASSWORD_BCRYPT);
        $jsonAcu = ($aceptaPolitica === 'si' && $datosAcudiente)
                   ? json_encode($datosAcudiente, JSON_UNESCAPED_UNICODE)
                   : null;

        $sql = 'INSERT INTO usuarios
                    (grado, nombre, correo_electronico, contrasena, acepta_politica, datos_acudiente)
                VALUES (?, ?, ?, ?, ?, ?)';

        $stmt = $this->db->prepare($sql);
        $stmt->execute([$grado, $nombre, $email, $hash, $aceptaPolitica, $jsonAcu]);

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
}
