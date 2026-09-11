<?php
/**
 * Modelo de Notas Personalizadas de Psicóloga a Paciente
 *
 * Gestiona las notas que la psicóloga escribe para un paciente específico
 * (distintas a las notas_sesion de la tabla citas).
 */
class NotaPacienteModel extends Model
{
    /**
     * Obtiene todas las notas de un paciente específico escritas por cualquier psicóloga.
     */
    public function getNotasByUsuario(int $idUsuario): array
    {
        $sql = "
            SELECT n.*, p.nombre AS psicologo_nombre
            FROM notas_paciente n
            JOIN psicologos p ON n.id_psicologo = p.id_psicologo
            WHERE n.id_usuario = ?
            ORDER BY n.fecha_creacion DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene las notas escritas por una psicóloga específica a un paciente.
     */
    public function getNotasByPsicologoAndUsuario(int $idPsicologo, int $idUsuario): array
    {
        $sql = "
            SELECT * FROM notas_paciente
            WHERE id_psicologo = ? AND id_usuario = ?
            ORDER BY fecha_creacion DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo, $idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene notas para los pacientes que tienen cita HOY con una psicóloga,
     * agrupadas por paciente.
     */
    public function getNotasParaPacientesDeHoy(int $idPsicologo): array
    {
        $sql = "
            SELECT DISTINCT
                u.id_usuario, u.nombre AS paciente_nombre,
                (SELECT COUNT(*) FROM notas_paciente np 
                 WHERE np.id_psicologo = ? AND np.id_usuario = u.id_usuario) AS total_notas
            FROM citas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_psicologo = ?
              AND c.fecha = CURRENT_DATE()
              AND c.estado != 'cancelada'
            ORDER BY u.nombre
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo, $idPsicologo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nueva nota para un paciente.
     */
    public function createNota(int $idPsicologo, int $idUsuario, string $titulo, string $contenido): bool
    {
        $sql = "INSERT INTO notas_paciente (id_psicologo, id_usuario, titulo, contenido) VALUES (?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idPsicologo, $idUsuario, $titulo, $contenido]);
    }

    /**
     * Elimina una nota (solo si pertenece a la psicóloga).
     */
    public function deleteNota(int $idNota, int $idPsicologo): bool
    {
        $sql = "DELETE FROM notas_paciente WHERE id_nota = ? AND id_psicologo = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idNota, $idPsicologo]);
    }
}
