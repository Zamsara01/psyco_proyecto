<?php
/**
 * SuperusuarioModel — restaurado para usar la tabla superusuarios
 */
class SuperusuarioModel extends Model
{
    public function findByCredentials(string $email, string $password): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT s.id_superusuario, u.*, r.nombre AS rol
             FROM superusuarios s
             JOIN usuario u ON s.id_usuario = u.id_usuario
             JOIN roles r ON u.id_rol = r.id_rol
             WHERE u.correo_electronico = :correo
               AND u.estado = "activo"
               AND r.nombre = "superusuario"'
        );
        $stmt->execute([':correo' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['contrasena']) && password_verify($password, $row['contrasena'])) {
            return $row;
        }
        return null;
    }
}
