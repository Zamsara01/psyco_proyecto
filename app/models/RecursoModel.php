<?php
/**
 * Modelo de Recursos de Acompañamiento
 *
 * El destino puede ser un paciente específico (id_paciente) o todos (NULL).
 */
class RecursoModel extends Model
{
    /**
     * Obtiene todos los recursos visibles para un paciente (identificado por id_paciente):
     * - Recursos globales (id_paciente IS NULL) de cualquier psicóloga
     * - Recursos específicos asignados a ese paciente
     */
    public function getRecursosByPaciente(int $idPaciente): array
    {
        $sql = "
            SELECT r.*, up.nombre AS psicologo_nombre
            FROM recursos_acompanamiento r
            JOIN psicologos p ON r.id_psicologo = p.id_psicologo
            JOIN usuario up ON p.id_usuario = up.id_usuario
            WHERE r.id_paciente = ? OR r.id_paciente IS NULL
            ORDER BY r.fecha_creacion DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPaciente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Lista todos los recursos publicados por una psicóloga.
     */
    public function getRecursosByPsicologo(int $idPsicologo): array
    {
        $sql = "
            SELECT r.*, u.nombre AS paciente_nombre
            FROM recursos_acompanamiento r
            LEFT JOIN paciente p ON r.id_paciente = p.id_paciente
            LEFT JOIN usuario u ON p.id_usuario = u.id_usuario
            WHERE r.id_psicologo = ?
            ORDER BY r.fecha_creacion DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea un nuevo recurso.
     *
     * @param int|null $idPaciente NULL = para todos los pacientes
     */
    public function createRecurso(
        int    $idPsicologo,
        ?int   $idPaciente,
        string $titulo,
        string $tipo,
        ?string $urlVideo,
        ?string $imagenRuta,
        string $descripcion = ''
    ): bool {
        $sql = "INSERT INTO recursos_acompanamiento
                    (id_psicologo, id_paciente, titulo, tipo, url_video, imagen_ruta, descripcion)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idPsicologo, $idPaciente, $titulo, $tipo, $urlVideo, $imagenRuta, $descripcion]);
    }

    /**
     * Elimina un recurso y devuelve la ruta de imagen (si existe) para borrar el archivo.
     *
     * @return string|false  Ruta de imagen a eliminar, false si no se encontró/no aplica
     */
    public function deleteRecurso(int $idRecurso, int $idPsicologo): string|false
    {
        // Obtener imagen_ruta antes de borrar
        $sel  = $this->db->prepare("SELECT imagen_ruta FROM recursos_acompanamiento WHERE id_recurso = ? AND id_psicologo = ?");
        $sel->execute([$idRecurso, $idPsicologo]);
        $row  = $sel->fetch(PDO::FETCH_ASSOC);
        if (!$row) return false;

        $del = $this->db->prepare("DELETE FROM recursos_acompanamiento WHERE id_recurso = ? AND id_psicologo = ?");
        $del->execute([$idRecurso, $idPsicologo]);
        return $row['imagen_ruta'] ?? '';
    }
}
