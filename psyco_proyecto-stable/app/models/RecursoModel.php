<?php
/**
 * Modelo de Recursos de Acompañamiento
 *
 * Soporta 3 tipos de contenido: video, mensaje, imagen.
 * El destino puede ser un paciente específico (id_usuario) o todos (NULL).
 */
class RecursoModel extends Model
{
    /**
     * Obtiene todos los recursos visibles para un usuario:
     * - Recursos globales (id_usuario IS NULL) de cualquier psicóloga
     * - Recursos específicos asignados a ese usuario
     */
    public function getRecursosByUsuario(int $idUsuario): array
    {
        $sql = "
            SELECT r.*, p.nombre AS psicologo_nombre
            FROM recursos_acompanamiento r
            JOIN psicologos p ON r.id_psicologo = p.id_psicologo
            WHERE r.id_usuario = ? OR r.id_usuario IS NULL
            ORDER BY r.fecha_creacion DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idUsuario]);
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
            LEFT JOIN usuarios u ON r.id_usuario = u.id_usuario
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
     * @param int|null $idUsuario NULL = para todos los pacientes
     */
    public function createRecurso(
        int    $idPsicologo,
        ?int   $idUsuario,
        string $titulo,
        string $tipo,
        ?string $urlVideo,
        ?string $imagenRuta,
        string $descripcion = ''
    ): bool {
        $sql = "INSERT INTO recursos_acompanamiento
                    (id_psicologo, id_usuario, titulo, tipo, url_video, imagen_ruta, descripcion)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idPsicologo, $idUsuario, $titulo, $tipo, $urlVideo, $imagenRuta, $descripcion]);
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
