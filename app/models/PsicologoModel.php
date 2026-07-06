<?php
/**
 * Modelo de Psicólogos
 *
 * Centraliza las consultas de psicólogos, especialidades
 * y disponibilidad semanal.
 */
class PsicologoModel extends Model
{
    /**
     * Obtiene todos los psicólogos activos con su especialidad
     * y sus bloques de disponibilidad semanal.
     *
     * @return array Array indexado listo para json_encode()
     */
    public function getAllWithAvailability(): array
    {
        $sql = "
            SELECT
                p.id_psicologo,
                p.nombre,
                p.foto_perfil,
                e.nombre        AS especialidad,
                d.dia_semana,
                d.hora_inicio,
                d.hora_fin
            FROM psicologos p
            JOIN especialidades e
                ON p.id_especialidad = e.id_especialidad
            LEFT JOIN disponibilidad_psicologos d
                ON p.id_psicologo = d.id_psicologo
               AND d.activo = 1
            WHERE p.estado = 'activo'
            ORDER BY p.id_psicologo, d.dia_semana, d.hora_inicio
        ";

        $stmt    = $this->db->query($sql);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $psicologos = [];

        foreach ($results as $row) {
            $id = (int) $row['id_psicologo'];

            if (!isset($psicologos[$id])) {
                // Foto: si no tiene, generar avatar automático
                $foto = !empty($row['foto_perfil'])
                    ? $row['foto_perfil']
                    : 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre']) . '&background=F97316&color=fff&size=128';

                $psicologos[$id] = [
                    'id'           => $id,
                    'nombre'       => $row['nombre'],
                    'especialidad' => $row['especialidad'],
                    'foto_perfil'  => $foto,
                    'disponibilidad' => [],
                ];
            }

            // Agregar bloque de horario si existe
            if (!empty($row['dia_semana'])) {
                $psicologos[$id]['disponibilidad'][] = [
                    'dia'    => $row['dia_semana'],
                    'inicio' => substr($row['hora_inicio'], 0, 5),   // HH:MM
                    'fin'    => substr($row['hora_fin'],    0, 5),
                ];
            }
        }

        return array_values($psicologos);   // índice numérico para JSON limpio
    }

    /**
     * Obtiene psicólogos activos que tienen disponibilidad en un día de la semana dado.
     *
     * @param string $diaSemana Nombre del día en español: 'Lunes', 'Martes', etc.
     * @return array
     */
    public function getPsicologosDisponiblesPorDia(string $diaSemana): array
    {
        $sql = "
            SELECT DISTINCT
                p.id_psicologo,
                p.nombre,
                p.foto_perfil,
                e.nombre AS especialidad
            FROM psicologos p
            JOIN especialidades e ON p.id_especialidad = e.id_especialidad
            JOIN disponibilidad_psicologos d ON p.id_psicologo = d.id_psicologo
            WHERE p.estado = 'activo'
              AND d.dia_semana = ?
              AND d.activo = 1
            ORDER BY p.nombre
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

    /**
     * Devuelve los slots horarios disponibles (cada hora) para un psicólogo en una fecha concreta.
     * Excluye las horas ya reservadas con estado pendiente o completada.
     *
     * @param int    $idPsicologo
     * @param string $fecha       Formato YYYY-MM-DD
     * @param string $diaSemana   Nombre del día en español
     * @return array Array de strings 'HH:MM'
     */
    public function getHorasDisponibles(int $idPsicologo, string $fecha, string $diaSemana): array
    {
        // 1. Obtener bloques de disponibilidad del día
        $sqlDispo = "
            SELECT hora_inicio, hora_fin
            FROM disponibilidad_psicologos
            WHERE id_psicologo = ?
              AND dia_semana = ?
              AND activo = 1
        ";
        $stmt = $this->db->prepare($sqlDispo);
        $stmt->execute([$idPsicologo, $diaSemana]);
        $bloques = $stmt->fetchAll(PDO::FETCH_ASSOC);

        if (empty($bloques)) return [];

        // 2. Obtener horas ya reservadas ese día
        $sqlOcupadas = "
            SELECT hora FROM citas
            WHERE id_psicologo = ?
              AND fecha = ?
              AND estado IN ('pendiente', 'completada')
        ";
        $stmt = $this->db->prepare($sqlOcupadas);
        $stmt->execute([$idPsicologo, $fecha]);
        $horasOcupadas = array_column($stmt->fetchAll(PDO::FETCH_ASSOC), 'hora');
        // Normalizar a HH:MM
        $horasOcupadas = array_map(fn($h) => substr($h, 0, 5), $horasOcupadas);

        // 3. Generar slots por hora dentro de cada bloque
        $slots = [];
        foreach ($bloques as $bloque) {
            $inicio = strtotime($bloque['hora_inicio']);
            $fin    = strtotime($bloque['hora_fin']);
            for ($t = $inicio; $t < $fin; $t += 3600) {
                $slot = date('H:i', $t);
                if (!in_array($slot, $horasOcupadas)) {
                    $slots[] = $slot;
                }
            }
        }
        sort($slots);
        return array_unique($slots);
    }

    /**
     * Verifica credenciales de un psicólogo.
     * 
     * @param string $email Correo electrónico
     * @param string $password Contraseña en texto plano
     * @return array|null Datos del psicólogo si las credenciales son válidas, null en caso contrario
     */
    public function findByCredentials(string $email, string $password): ?array
    {
        $stmt = $this->db->prepare(
            'SELECT * FROM psicologos WHERE correo_electronico = :correo AND estado = "activo"'
        );
        $stmt->execute([':correo' => $email]);
        $row = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($row && password_verify($password, $row['contrasena'])) {
            return $row;
        }
        return null;
    }

    /**
     * Obtiene todos los psicólogos activos (para dropdown de edición de citas).
     */
    public function getAllActivos(): array
    {
        $sql = "
            SELECT p.id_psicologo, p.nombre, p.foto_perfil, e.nombre AS especialidad
            FROM psicologos p
            JOIN especialidades e ON p.id_especialidad = e.id_especialidad
            WHERE p.estado = 'activo'
            ORDER BY p.nombre
        ";
        $stmt = $this->db->query($sql);
        $rows = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($rows as &$row) {
            if (empty($row['foto_perfil'])) {
                $row['foto_perfil'] = 'https://ui-avatars.com/api/?name=' . urlencode($row['nombre']) . '&background=F97316&color=fff&size=128';
            }
        }
        return $rows;
    }

    /**
     * Obtiene todos los bloques de disponibilidad activos de una psicóloga.
     */
    public function getDisponibilidad(int $idPsicologo): array
    {
        $sql = "SELECT id_disponibilidad, dia_semana, hora_inicio, hora_fin 
                FROM disponibilidad_psicologos 
                WHERE id_psicologo = ? AND activo = 1
                ORDER BY FIELD(dia_semana, 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'), hora_inicio";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Agrega un nuevo bloque de disponibilidad para una psicóloga.
     */
    public function addDisponibilidad(int $idPsicologo, string $dia, string $inicio, string $fin): bool
    {
        // Verificar si ya existe exactamente el mismo bloque activo para evitar duplicados
        $sqlCheck = "SELECT id_disponibilidad FROM disponibilidad_psicologos 
                     WHERE id_psicologo = ? AND dia_semana = ? AND hora_inicio = ? AND hora_fin = ? AND activo = 1";
        $stmt = $this->db->prepare($sqlCheck);
        $stmt->execute([$idPsicologo, $dia, $inicio, $fin]);
        if ($stmt->fetch()) {
            return false;
        }

        $sql = "INSERT INTO disponibilidad_psicologos (id_psicologo, dia_semana, hora_inicio, hora_fin, activo) VALUES (?, ?, ?, ?, 1)";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idPsicologo, $dia, $inicio, $fin]);
    }

    /**
     * Elimina (desactiva) un bloque de disponibilidad.
     */
    public function deleteDisponibilidad(int $idPsicologo, int $idDisponibilidad): bool
    {
        $sql = "UPDATE disponibilidad_psicologos SET activo = 0 WHERE id_disponibilidad = ? AND id_psicologo = ?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idDisponibilidad, $idPsicologo]);
    }
}

