<?php
/**
 * Modelo para la tabla recordatorios
 */
class RecordatorioModel extends Model
{
    /**
     * Registra un recordatorio programado (antes de enviar)
     */
    public function crearRecordatorio(
        int $idCita,
        string $mensaje,
        string $fechaProgramada,
        string $canal = 'correo'
    ): int {
        $sql = "
            INSERT INTO recordatorios (id_cita, mensaje, fecha_programada, canal, estado_envio)
            VALUES (?, ?, ?, ?, 'pendiente')
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idCita, $mensaje, $fechaProgramada, $canal]);
        return (int)$this->db->lastInsertId();
    }

    /**
     * Marca un recordatorio como enviado
     */
    public function marcarEnviado(int $idRecordatorio): bool
    {
        $sql = "
            UPDATE recordatorios 
            SET estado_envio = 'enviado', fecha_envio = NOW() 
            WHERE id_recordatorio = ?
        ";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idRecordatorio]);
    }

    /**
     * Marca un recordatorio como fallido
     */
    public function marcarFallido(int $idRecordatorio): bool
    {
        $sql = "
            UPDATE recordatorios 
            SET estado_envio = 'fallido', fecha_envio = NOW() 
            WHERE id_recordatorio = ?
        ";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idRecordatorio]);
    }

    /**
     * Obtiene recordatorios pendientes para una cita
     */
    public function getByCita(int $idCita): array
    {
        $stmt = $this->db->prepare("
            SELECT * FROM recordatorios WHERE id_cita = ? ORDER BY fecha_programada
        ");
        $stmt->execute([$idCita]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene recordatorios pendientes de envío (para reintentos)
     */
    public function getPendientes(int $limite = 50): array
    {
        $stmt = $this->db->prepare("
            SELECT r.*, c.fecha, c.hora
            FROM recordatorios r
            JOIN citas c ON r.id_cita = c.id_cita
            WHERE r.estado_envio = 'pendiente'
            AND r.fecha_programada <= NOW()
            ORDER BY r.fecha_programada
            LIMIT ?
        ");
        $stmt->bindValue(1, $limite, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
}