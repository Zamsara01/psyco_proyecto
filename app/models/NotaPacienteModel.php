<?php
/**
 * NotaPacienteModel — notas privadas del psicólogo sobre un paciente.
 * Usa id_paciente (FK a paciente). id_cita es NULLable.
 * PRIVACIDAD: ningún método aquí debe ser llamado desde el panel del paciente.
 */
class NotaPacienteModel extends Model
{
    /**
     * Obtiene notas del psicólogo sobre un paciente (identificado por id_paciente).
     * Solo para uso del psicólogo — nunca exponer al panel del paciente.
     */
    public function getNotasByPaciente(int $idPaciente): array
    {
        $sql = "
            SELECT n.*, up.nombre AS psicologo_nombre
            FROM notas_paciente n
            JOIN psicologos ps ON n.id_psicologo = ps.id_psicologo
            JOIN usuario up    ON ps.id_usuario  = up.id_usuario
            WHERE n.id_paciente = ?
            ORDER BY n.fecha_creacion DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPaciente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Notas de un psicólogo específico sobre un paciente específico. */
    public function getNotasByPsicologoAndPaciente(int $idPsicologo, int $idPaciente): array
    {
        $sql = "SELECT * FROM notas_paciente WHERE id_psicologo=? AND id_paciente=? ORDER BY fecha_creacion DESC";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo, $idPaciente]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /** Pacientes que tienen cita hoy con este psicólogo, con conteo de notas. */
    public function getNotasParaPacientesDeHoy(int $idPsicologo): array
    {
        $sql = "
            SELECT DISTINCT u.id_usuario, p.id_paciente, u.nombre AS paciente_nombre,
                   (SELECT COUNT(*) FROM notas_paciente np
                    WHERE np.id_psicologo=? AND np.id_paciente=p.id_paciente) AS total_notas
            FROM citas c
            JOIN paciente p ON c.id_paciente = p.id_paciente
            JOIN usuario u  ON p.id_usuario  = u.id_usuario
            WHERE c.id_psicologo=? AND c.fecha=CURRENT_DATE() AND c.estado!='cancelada'
            ORDER BY u.nombre
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo, $idPsicologo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Crea una nota. Valida que el psicólogo y el paciente sean coherentes con la cita.
     * @param int|null $idCita NULL = nota general sin cita
     */
    public function createNota(int $idPsicologo, int $idPaciente, string $titulo,
                               string $contenido, string $tipoNota = 'general',
                               ?int $idCita = null): bool
    {
        // Asegurar que tipo_nota existe (safe idempotente)
        try {
            $this->db->exec("ALTER TABLE notas_paciente ADD COLUMN tipo_nota VARCHAR(50) NOT NULL DEFAULT 'general' AFTER contenido");
        } catch (\Exception $e) {}

        // Si se indicó cita, validar que pertenece al mismo psicólogo y paciente
        if ($idCita !== null) {
            $stmtVal = $this->db->prepare(
                "SELECT id_cita FROM citas WHERE id_cita=? AND id_psicologo=? AND id_paciente=?"
            );
            $stmtVal->execute([$idCita, $idPsicologo, $idPaciente]);
            if (!$stmtVal->fetch()) {
                error_log("[NotaPacienteModel] Intento de nota con cita inválida: cita=$idCita psicologo=$idPsicologo paciente=$idPaciente");
                return false;
            }
        }

        $sql = "INSERT INTO notas_paciente (id_psicologo, id_paciente, titulo, contenido, tipo_nota, id_cita)
                VALUES (?, ?, ?, ?, ?, ?)";
        return $this->db->prepare($sql)->execute([$idPsicologo, $idPaciente, $titulo, $contenido, $tipoNota, $idCita]);
    }

    /** Elimina una nota (solo si pertenece al psicólogo). */
    public function deleteNota(int $idNota, int $idPsicologo): bool
    {
        return $this->db->prepare("DELETE FROM notas_paciente WHERE id_nota=? AND id_psicologo=?")
                        ->execute([$idNota, $idPsicologo]);
    }

    /** Actualiza el título y contenido de una nota (solo si pertenece al psicólogo). */
    public function updateNota(int $idNota, int $idPsicologo, string $titulo, string $contenido): bool
    {
        return $this->db->prepare("UPDATE notas_paciente SET titulo=?, contenido=? WHERE id_nota=? AND id_psicologo=?")
                        ->execute([$titulo, $contenido, $idNota, $idPsicologo]);
    }
}
