<?php
class SuperusuarioModel extends Model
{
    public function findByCredentials(string $email, string $password): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM superusuarios WHERE correo_electronico = :correo AND estado = "activo"'
        );
        $stmt->execute([':correo' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['contrasena'])) {
            return $row;
        }
        return null;
    }
}
