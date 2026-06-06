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
}
