<?php
/**
 * UserModel — gestiona la tabla `usuario` (todos los roles) y la tabla `paciente`.
 * Las contraseñas se almacenan con password_hash() (bcrypt).
 *
 * Esquema actual:
 *   usuario(id_usuario, nombre, correo_electronico, contrasena, estado,
 *           id_rol, fecha_registro, google_id, avatar_url, email_verified_at)
 *   roles(id_rol, nombre)
 *   paciente(id_paciente, id_usuario, grado, acepta_politica, fecha_aceptacion_politica)
 *   datos_acudiente(id_acudiente, id_paciente, nombre, cedula, relacion, correo)
 */
class UserModel extends Model
{
    // ── SQL base que devuelve el rol como texto ────────────────────────
    private const SQL_ROL_JOIN = "JOIN roles r ON u.id_rol = r.id_rol";

    // ── Lectura ───────────────────────────────────────────────────────

    /** Todos los pacientes (sin contraseña). */
    public function getAll(): array
    {
        $stmt = $this->db->query(
            'SELECT u.id_usuario, p.id_paciente, p.grado, u.nombre,
                    u.correo_electronico, u.estado, u.fecha_registro, r.nombre AS rol
             FROM usuario u
             JOIN roles r ON u.id_rol = r.id_rol
             JOIN paciente p ON u.id_usuario = p.id_usuario
             WHERE r.nombre = "paciente"
             ORDER BY u.fecha_registro DESC'
        );
        return $stmt->fetchAll();
    }

    /** Busca un usuario por PK — devuelve datos de usuario + perfil paciente + acudiente. */
    public function findById(int $id): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT u.id_usuario, u.nombre, u.correo_electronico, u.estado,
                    u.google_id, u.avatar_url, u.email_verified_at, r.nombre AS rol,
                    p.id_paciente, p.grado, p.acepta_politica, p.fecha_aceptacion_politica,
                    da.nombre  AS acudiente_nombre,
                    da.cedula  AS acudiente_cedula,
                    da.relacion AS acudiente_relacion,
                    da.correo  AS acudiente_correo
             FROM usuario u
             JOIN roles r ON u.id_rol = r.id_rol
             LEFT JOIN paciente p ON u.id_usuario = p.id_usuario
             LEFT JOIN datos_acudiente da ON p.id_paciente = da.id_paciente
             WHERE u.id_usuario = ?'
        );
        $stmt->execute([$id]);
        $row = $stmt->fetch();
        return $row ?: null;
    }

    /**
     * Verifica credenciales (cualquier rol).
     * Devuelve la fila de `usuario` + nombre del rol, o null si falla.
     */
    public function findByCredentials(string $email, string $password): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT u.*, r.nombre AS rol
             FROM usuario u
             JOIN roles r ON u.id_rol = r.id_rol
             WHERE u.correo_electronico = :correo AND u.estado = "activo"'
        );
        $stmt->execute([':correo' => $email]);
        $row = $stmt->fetch();

        if (!$row) return null;

        // Usuarios Google-only no tienen contraseña
        if (empty($row['contrasena'])) {
            // Rechazar login por contraseña — deben usar Google
            return null;
        }

        if (password_verify($password, $row['contrasena'])) {
            return $row;
        }
        return null;
    }

    // ── Escritura ─────────────────────────────────────────────────────

    /**
     * Registra un nuevo paciente (transacción: usuario + paciente + datos_acudiente).
     * @return int ID del usuario insertado
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
        $hash = password_hash($password, PASSWORD_BCRYPT);

        $this->db->beginTransaction();
        try {
            // 1. Obtener id_rol de paciente
            $rolStmt = $this->db->prepare("SELECT id_rol FROM roles WHERE nombre = 'paciente'");
            $rolStmt->execute();
            $idRol = (int) $rolStmt->fetchColumn();

            // 2. Insertar en usuario
            $stmt = $this->db->prepare(
                'INSERT INTO usuario (nombre, correo_electronico, contrasena, id_rol) VALUES (?, ?, ?, ?)'
            );
            $stmt->execute([$nombre, $email, $hash, $idRol]);
            $idUsuario = (int) $this->db->lastInsertId();

            // 3. Insertar en paciente
            $fechaAcep = ($aceptaPolitica === 'si') ? date('Y-m-d H:i:s') : null;
            $stmtPac = $this->db->prepare(
                'INSERT INTO paciente (id_usuario, grado, acepta_politica, fecha_aceptacion_politica)
                 VALUES (?, ?, ?, ?)'
            );
            $stmtPac->execute([$idUsuario, $grado, $aceptaPolitica, $fechaAcep]);
            $idPaciente = (int) $this->db->lastInsertId();

            // 4. Insertar acudiente si corresponde
            if ($nombreAcudiente !== '') {
                $stmtAcu = $this->db->prepare(
                    'INSERT INTO datos_acudiente (id_paciente, nombre, cedula, relacion, correo)
                     VALUES (?, ?, ?, ?, ?)'
                );
                $stmtAcu->execute([$idPaciente, $nombreAcudiente, $cedulaAcudiente,
                                   $relacionAcudiente, $correoAcudiente]);
            }

            $this->db->commit();
            return $idUsuario;
        } catch (\Throwable $e) {
            $this->db->rollBack();
            throw $e;
        }
    }

    /** Busca pacientes activos por nombre o correo (para agendar citas). */
    public function buscarTodos(string $query): array
    {
        $like = '%' . $query . '%';
        $sql = "
            SELECT u.id_usuario, p.id_paciente, u.nombre, u.correo_electronico, p.grado
            FROM usuario u
            JOIN roles r ON u.id_rol = r.id_rol
            LEFT JOIN paciente p ON u.id_usuario = p.id_usuario
            WHERE (u.nombre LIKE ? OR u.correo_electronico LIKE ?)
              AND u.estado = 'activo' AND r.nombre = 'paciente'
            ORDER BY u.nombre
            LIMIT 20
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Comprueba si un correo ya está registrado. */
    public function emailExists(string $email): bool
    {
        $stmt = $this->db->prepare('SELECT COUNT(*) FROM usuario WHERE correo_electronico = ?');
        $stmt->execute([$email]);
        return (int) $stmt->fetchColumn() > 0;
    }

    // ── Google OAuth ──────────────────────────────────────────────────

    /**
     * Busca un usuario por google_id o correo.
     * Actualiza avatar/google_id si ya existía con otro método de login.
     */
    public function findByGoogle(array $googleUser): ?array
    {
        $googleId = $googleUser['sub']     ?? '';
        $email    = $googleUser['email']   ?? '';
        $avatar   = $googleUser['picture'] ?? null;

        // 1. Por google_id
        if ($googleId) {
            $stmt = $this->db->prepare(
                'SELECT u.*, r.nombre AS rol
                 FROM usuario u JOIN roles r ON u.id_rol = r.id_rol
                 WHERE u.google_id = ? LIMIT 1'
            );
            $stmt->execute([$googleId]);
            $user = $stmt->fetch();
            if ($user) {
                if ($avatar && $user['avatar_url'] !== $avatar) {
                    $this->db->prepare('UPDATE usuario SET avatar_url=? WHERE id_usuario=?')
                             ->execute([$avatar, $user['id_usuario']]);
                    $user['avatar_url'] = $avatar;
                }
                return $user;
            }
        }

        // 2. Por correo (vincula google_id)
        if ($email) {
            $stmt = $this->db->prepare(
                'SELECT u.*, r.nombre AS rol
                 FROM usuario u JOIN roles r ON u.id_rol = r.id_rol
                 WHERE u.correo_electronico = ? LIMIT 1'
            );
            $stmt->execute([$email]);
            $user = $stmt->fetch();
            if ($user) {
                $this->db->prepare('UPDATE usuario SET google_id=?, avatar_url=? WHERE id_usuario=?')
                         ->execute([$googleId, $avatar, $user['id_usuario']]);
                $user['google_id']  = $googleId;
                $user['avatar_url'] = $avatar;
                return $user;
            }
        }
        return null;
    }

    /** Dashboard del superadmin: pacientes activos clasificados por trastorno. */
    public function getActivePatientsWithDisorder(): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';

        $sql = "
            SELECT u.id_usuario, p.id_paciente, u.nombre, u.correo_electronico, p.grado,
                   (SELECT c.motivo_consulta
                    FROM citas c
                    WHERE c.id_paciente = p.id_paciente
                    ORDER BY c.fecha DESC, c.hora DESC
                    LIMIT 1) AS motivo_consulta
            FROM usuario u
            JOIN roles r ON u.id_rol = r.id_rol
            JOIN paciente p ON u.id_usuario = p.id_usuario
            WHERE u.estado = 'activo' AND r.nombre = 'paciente'
            ORDER BY u.nombre ASC
        ";
        $patients = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        foreach ($patients as &$p) {
            $disorder = 'Sin especificar';
            if (!empty($p['motivo_consulta'])) {
                try {
                    $dec = mb_strtolower(EncryptionService::decrypt($p['motivo_consulta']), 'UTF-8');
                    if (str_contains($dec, 'ansiedad'))   $disorder = 'Ansiedad';
                    elseif (str_contains($dec, 'depresión') || str_contains($dec, 'depresion')) $disorder = 'Depresión';
                    elseif (str_contains($dec, 'estrés')  || str_contains($dec, 'estres'))     $disorder = 'Estrés';
                    elseif (str_contains($dec, 'autoestima')) $disorder = 'Autoestima';
                    elseif (str_contains($dec, 'duelo'))  $disorder = 'Duelo';
                    elseif (str_contains($dec, 'concentración') || str_contains($dec, 'aprendizaje')
                         || str_contains($dec, 'lectura') || str_contains($dec, 'académico'))  $disorder = 'Académico / Concentración';
                    elseif (str_contains($dec, 'adaptación') || str_contains($dec, 'emociones')
                         || str_contains($dec, 'ira') || str_contains($dec, 'bullying'))       $disorder = 'Adaptación / Conducta';
                    else $disorder = 'Otros';
                } catch (\Exception $e) {}
            }
            $p['trastorno'] = $disorder;
            unset($p['motivo_consulta']);
        }
        return $patients;
    }
}
