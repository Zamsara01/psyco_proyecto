<?php
/**
 * PsicologoModel
 * psicologos(id_psicologo, id_usuario [UNIQUE], id_especialidad, telefono, foto_perfil)
 * Los datos personales (nombre, correo, estado, etc.) viven en `usuario`.
 */
class PsicologoModel extends Model
{
    public function getAllWithAvailability(): array
    {
        $sql = "
            SELECT p.id_psicologo, u.nombre, u.avatar_url AS foto_perfil,
                   e.nombre AS especialidad,
                   d.dia_semana, d.hora_inicio, d.hora_fin
            FROM psicologos p
            JOIN usuario u ON p.id_usuario = u.id_usuario
            JOIN especialidades e ON p.id_especialidad = e.id_especialidad
            LEFT JOIN disponibilidad_psicologos d
                   ON p.id_psicologo = d.id_psicologo AND d.activo = 1
            WHERE u.estado = 'activo'
            ORDER BY p.id_psicologo, d.dia_semana, d.hora_inicio
        ";
        $results = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);

        $psicologos = [];
        foreach ($results as $row) {
            $id = (int)$row['id_psicologo'];
            if (!isset($psicologos[$id])) {
                $foto = !empty($row['foto_perfil'])
                    ? $row['foto_perfil']
                    : 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre']) . '&background=F97316&color=fff&size=128';
                $psicologos[$id] = [
                    'id'             => $id,
                    'nombre'         => $row['nombre'],
                    'especialidad'   => $row['especialidad'],
                    'foto_perfil'    => $foto,
                    'disponibilidad' => [],
                ];
            }
            if (!empty($row['dia_semana'])) {
                $psicologos[$id]['disponibilidad'][] = [
                    'dia'    => $row['dia_semana'],
                    'inicio' => substr($row['hora_inicio'], 0, 5),
                    'fin'    => substr($row['hora_fin'],    0, 5),
                ];
            }
        }
        return array_values($psicologos);
    }

    public function getPsicologosDisponiblesPorDia(string $diaSemana): array
    {
        $sql = "
            SELECT DISTINCT p.id_psicologo, u.nombre, u.avatar_url AS foto_perfil,
                   e.nombre AS especialidad
            FROM psicologos p
            JOIN usuario u ON p.id_usuario = u.id_usuario
            JOIN especialidades e ON p.id_especialidad = e.id_especialidad
            JOIN disponibilidad_psicologos d ON p.id_psicologo = d.id_psicologo
            WHERE u.estado = 'activo' AND d.dia_semana = ? AND d.activo = 1
            ORDER BY u.nombre
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$diaSemana]);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$row) {
            if (empty($row['foto_perfil'])) {
                $row['foto_perfil'] = 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre']) . '&background=F97316&color=fff&size=128';
            }
        }
        return $rows;
    }

    public function getHorasDisponibles(int $idPsicologo, string $fecha, string $diaSemana): array
    {
        $sqlDispo = "
            SELECT hora_inicio, hora_fin FROM disponibilidad_psicologos
            WHERE id_psicologo = ? AND dia_semana = ? AND activo = 1
        ";
        $stmt = $this->db->prepare($sqlDispo);
        $stmt->execute([$idPsicologo, $diaSemana]);
        $bloques = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if (empty($bloques)) return [];

        $sqlOcupadas = "
            SELECT hora FROM citas WHERE id_psicologo = ? AND fecha = ?
              AND estado IN ('pendiente','completada')
        ";
        $stmt = $this->db->prepare($sqlOcupadas);
        $stmt->execute([$idPsicologo, $fecha]);
        $horasOcupadas = array_map(fn($h) => substr($h, 0, 5),
                                   array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'hora'));

        $slots = [];
        foreach ($bloques as $bloque) {
            $ini = strtotime($bloque['hora_inicio']);
            $fin = strtotime($bloque['hora_fin']);
            for ($t = $ini; $t < $fin; $t += 3600) {
                $slot = date('H:i', $t);
                if (!in_array($slot, $horasOcupadas)) $slots[] = $slot;
            }
        }
        sort($slots);
        return array_unique($slots);
    }

    public function findByCredentials(string $email, string $password): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT p.*, u.nombre, u.correo_electronico, u.contrasena, u.estado,
                    u.id_usuario, r.nombre AS rol
             FROM psicologos p
             JOIN usuario u ON p.id_usuario = u.id_usuario
             JOIN roles r ON u.id_rol = r.id_rol
             WHERE u.correo_electronico = :correo
               AND u.estado = "activo" AND r.nombre = "psicologo"'
        );
        $stmt->execute([':correo' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && !empty($row['contrasena']) && password_verify($password, $row['contrasena'])) {
            return $row;
        }
        return null;
    }

    public function getAllActivos(): array
    {
        $sql = "
            SELECT p.id_psicologo, u.nombre, u.avatar_url AS foto_perfil, e.nombre AS especialidad
            FROM psicologos p
            JOIN usuario u ON p.id_usuario = u.id_usuario
            JOIN especialidades e ON p.id_especialidad = e.id_especialidad
            WHERE u.estado = 'activo'
            ORDER BY u.nombre
        ";
        $rows = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$row) {
            if (empty($row['foto_perfil'])) {
                $row['foto_perfil'] = 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre']) . '&background=F97316&color=fff&size=128';
            }
        }
        return $rows;
    }

    public function getDisponibilidad(int $idPsicologo): array
    {
        $sql = "SELECT id_disponibilidad, dia_semana,
                       CONCAT(SUBSTRING(hora_inicio,1,5), '-', SUBSTRING(hora_fin,1,5)) AS jornada,
                       hora_inicio, hora_fin
                FROM disponibilidad_psicologos
                WHERE id_psicologo = ? AND activo = 1
                ORDER BY FIELD(dia_semana,'Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo')";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addDisponibilidad(int $idPsicologo, string $dia, string $jornada): bool
    {
        $check = $this->db->prepare(
            "SELECT id_disponibilidad FROM disponibilidad_psicologos WHERE id_psicologo=? AND dia_semana=? AND activo=1"
        );
        $check->execute([$idPsicologo, $dia]);
        if ($check->fetch()) return false;

        $partes = explode('-', $jornada);
        $inicio = ($partes[0] ?? '') . ':00';
        $fin    = ($partes[1] ?? '') . ':00';

        $stmt = $this->db->prepare(
            "INSERT INTO disponibilidad_psicologos (id_psicologo, dia_semana, hora_inicio, hora_fin, activo)
             VALUES (?, ?, ?, ?, 1)"
        );
        return $stmt->execute([$idPsicologo, $dia, $inicio, $fin]);
    }

    public function deleteDisponibilidad(int $idPsicologo, int $idDisponibilidad): bool
    {
        $stmt = $this->db->prepare(
            "UPDATE disponibilidad_psicologos SET activo=0 WHERE id_disponibilidad=? AND id_psicologo=?"
        );
        return $stmt->execute([$idDisponibilidad, $idPsicologo]);
    }
}
