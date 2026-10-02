<?php
/**
 * Modelo para gestionar solicitudes de creación de psicólogos.
 *
 * Flujo:
 *   1. Psicólogo A propone → crearSolicitud()
 *   2. Psicólogo B (distinto) aprueba → aprobarSolicitud()
 *      → el registro pasa a la tabla `psicologos`
 *   3. Psicólogo B rechaza → rechazarSolicitud() (elimina la solicitud)
 */
class SolicitudPsicologoModel extends Model
{
    /**
     * Registra una nueva solicitud de psicólogo.
     */
    public function crearSolicitud(
        string $nombre,
        string $correo,
        string $password,
        int $idEspecialidad,
        int $propuestoPor
    ): int {
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $sql  = 'INSERT INTO psicologos_solicitudes
                     (nombre, correo_electronico, contrasena, id_especialidad, propuesto_por)
                 VALUES (?, ?, ?, ?, ?)';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$nombre, $correo, $hash, $idEspecialidad, $propuestoPor]);
        return (int) $this->db->lastInsertId();
    }

    /**
     * Aprueba una solicitud: mueve el registro a `psicologos` y elimina la solicitud.
     * El aprobador NO puede ser el mismo que propuso.
     */
    public function aprobarSolicitud(int $idSolicitud, int $idAprobador): bool
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM psicologos_solicitudes WHERE id_solicitud = ?'
        );
        $stmt->execute([$idSolicitud]);
        $solicitud = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$solicitud) return false;
        if ((int)$solicitud['propuesto_por'] === $idAprobador) return false;

        $this->db->beginTransaction();
        try {
            $ins = $this->db->prepare(
                'INSERT INTO psicologos
                     (id_especialidad, nombre, correo_electronico, contrasena, estado)
                 VALUES (?, ?, ?, ?, "activo")'
            );
            $ins->execute([
                $solicitud['id_especialidad'],
                $solicitud['nombre'],
                $solicitud['correo_electronico'],
                $solicitud['contrasena'],
            ]);

            $del = $this->db->prepare(
                'DELETE FROM psicologos_solicitudes WHERE id_solicitud = ?'
            );
            $del->execute([$idSolicitud]);

            $this->db->commit();
            return true;
        } catch (\Exception $e) {
            $this->db->rollBack();
            return false;
        }
    }

    /**
     * Rechaza y elimina una solicitud.
     * Solo puede hacerlo un psicólogo distinto al proponente.
     */
    public function rechazarSolicitud(int $idSolicitud, int $idAprobador): bool
    {
        $stmt = $this->db->prepare(
            'SELECT propuesto_por FROM psicologos_solicitudes WHERE id_solicitud = ?'
        );
        $stmt->execute([$idSolicitud]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if (!$row) return false;
        if ((int)$row['propuesto_por'] === $idAprobador) return false;

        $del = $this->db->prepare(
            'DELETE FROM psicologos_solicitudes WHERE id_solicitud = ?'
        );
        $del->execute([$idSolicitud]);
        return true;
    }

    /**
     * Obtiene solicitudes que el psicólogo actual PUEDE aprobar (no las suyas propias).
     */
    public function obtenerPendientes(int $idPsicologoActual): array
    {
        $sql = '
            SELECT
                s.id_solicitud,
                s.nombre,
                s.correo_electronico,
                s.fecha_solicitud,
                e.nombre    AS especialidad,
                p.nombre    AS propuesto_por_nombre
            FROM psicologos_solicitudes s
            JOIN especialidades e  ON s.id_especialidad = e.id_especialidad
            JOIN psicologos p      ON s.propuesto_por   = p.id_psicologo
            WHERE s.propuesto_por != ?
            ORDER BY s.fecha_solicitud DESC
        ';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologoActual]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene las propuestas que el psicólogo actual ha enviado (para que las vea).
     */
    public function obtenerMisPropuestas(int $idPsicologoActual): array
    {
        $sql = '
            SELECT
                s.id_solicitud,
                s.nombre,
                s.correo_electronico,
                s.fecha_solicitud,
                e.nombre AS especialidad
            FROM psicologos_solicitudes s
            JOIN especialidades e ON s.id_especialidad = e.id_especialidad
            WHERE s.propuesto_por = ?
            ORDER BY s.fecha_solicitud DESC
        ';
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologoActual]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Verifica si ya existe una solicitud o un psicólogo activo con ese correo.
     */
    public function correoExiste(string $correo): bool
    {
        $s1 = $this->db->prepare('SELECT COUNT(*) FROM psicologos_solicitudes WHERE correo_electronico = ?');
        $s1->execute([$correo]);
        if ((int)$s1->fetchColumn() > 0) return true;

        $s2 = $this->db->prepare('SELECT COUNT(*) FROM psicologos WHERE correo_electronico = ?');
        $s2->execute([$correo]);
        return (int)$s2->fetchColumn() > 0;
    }
}
