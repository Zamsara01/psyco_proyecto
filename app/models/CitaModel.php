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
}
