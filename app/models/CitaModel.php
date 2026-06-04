<?php
/**
 * Modelo de Citas
 *
 * Centraliza las consultas relacionadas con las citas (reservas)
 * de los usuarios con los psicólogos.
 */
class CitaModel extends Model
{
    /**
     * Obtiene el número de citas programadas por fecha.
     * Solo considera citas pendientes o completadas.
     *
     * @return array Un diccionario con formato ['YYYY-MM-DD' => total_citas]
     */
    public function getOcupacionPorFecha(): array
    {
        $sql = "
            SELECT fecha, COUNT(*) as total_citas
            FROM citas
            WHERE estado IN ('pendiente', 'completada')
            GROUP BY fecha
        ";

        $stmt = $this->db->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $ocupacion = [];
        foreach ($results as $row) {
            $ocupacion[$row['fecha']] = (int)$row['total_citas'];
        }

        return $ocupacion;
    }

    /**
     * Obtiene estadísticas para el panel superior de la psicóloga.
     */
    public function getDashboardStats(int $idPsicologo): array
    {
        // Sesiones este mes (cualquier estado excepto cancelada)
        $sql1 = "SELECT COUNT(*) FROM citas 
                 WHERE id_psicologo = ? 
                 AND MONTH(fecha) = MONTH(CURRENT_DATE()) 
                 AND YEAR(fecha) = YEAR(CURRENT_DATE())
                 AND estado != 'cancelada'";
        $stmt = $this->db->prepare($sql1);
        $stmt->execute([$idPsicologo]);
        $sesionesMes = $stmt->fetchColumn();

        // Citas Pendientes (hoy o futuro)
        $sql2 = "SELECT COUNT(*) FROM citas 
                 WHERE id_psicologo = ? 
                 AND estado = 'pendiente' 
                 AND fecha >= CURRENT_DATE()";
        $stmt = $this->db->prepare($sql2);
        $stmt->execute([$idPsicologo]);
        $pendientesHoy = $stmt->fetchColumn();

        // Nuevos Diagnósticos (citas del mes)
        // Alta Médica (citas completadas del mes)
        $sql3 = "SELECT COUNT(*) FROM citas 
                 WHERE id_psicologo = ? 
                 AND estado = 'completada'
                 AND MONTH(fecha) = MONTH(CURRENT_DATE()) 
                 AND YEAR(fecha) = YEAR(CURRENT_DATE())";
        $stmt = $this->db->prepare($sql3);
        $stmt->execute([$idPsicologo]);
        $altasMedicas = $stmt->fetchColumn();

        return [
            'sesiones_mes' => $sesionesMes ?: 0,
            'pendientes_hoy' => $pendientesHoy ?: 0,
            'nuevos_diagnosticos' => ceil($sesionesMes / 4), // Dato estimado para demo
            'altas_medicas' => $altasMedicas ?: 0
        ];
    }

    /**
     * Obtiene el listado de citas/pacientes recientes
     */
    public function getCitasRecientes(int $idPsicologo, int $limit = 10): array
    {
        $sql = "
            SELECT 
                c.id_cita, c.fecha, c.hora, c.estado, c.motivo_consulta, c.notas_sesion,
                u.nombre AS paciente_nombre, u.correo_electronico, u.id_usuario
            FROM citas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_psicologo = ?
            ORDER BY c.fecha DESC, c.hora DESC
            LIMIT ?
        ";
        $stmt = $this->db->prepare($sql);
        // PDO bindValue ensures limit is int
        $stmt->bindValue(1, $idPsicologo, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit, PDO::PARAM_INT);
        $stmt->execute();
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene las citas pendientes de hoy para la barra lateral
     */
    public function getCitasHoy(int $idPsicologo): array
    {
        $sql = "
            SELECT 
                c.id_cita, c.hora, c.motivo_consulta,
                u.nombre AS paciente_nombre
            FROM citas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_psicologo = ?
            AND c.fecha = CURRENT_DATE()
            AND c.estado = 'pendiente'
            ORDER BY c.hora ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}
