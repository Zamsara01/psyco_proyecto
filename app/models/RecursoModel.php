<?php
/**
 * Modelo de Recursos de Acompañamiento
 *
 * Gestiona los videos y recursos recomendados por la psicóloga a pacientes específicos.
 */
class RecursoModel extends Model
{
    /**
     * Obtiene todos los recursos asignados a un usuario.
     */
    public function getRecursosByUsuario(int $idUsuario): array
    {
        $sql = "
            SELECT r.*, p.nombre AS psicologo_nombre
            FROM recursos_acompanamiento r
            JOIN psicologos p ON r.id_psicologo = p.id_psicologo
            WHERE r.id_usuario = ?
            ORDER BY r.fecha_creacion DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idUsuario]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo recurso para un paciente.
     */
    public function createRecurso(int $idPsicologo, int $idUsuario, string $titulo, string $urlVideo, string $descripcion = ''): bool
    {
        $sql = "INSERT INTO recursos_acompanamiento (id_psicologo, id_usuario, titulo, url_video, descripcion) VALUES (?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idPsicologo, $idUsuario, $titulo, $urlVideo, $descripcion]);
    }

    /**
     * Elimina un recurso (solo si pertenece a la psicóloga).
     */
    public function deleteRecurso(int $idRecurso, int $idPsicologo): bool
    {
        $sql = "DELETE FROM recursos_acompanamiento WHERE id_recurso = ? AND id_psicologo = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idRecurso, $idPsicologo]);
    }
}
