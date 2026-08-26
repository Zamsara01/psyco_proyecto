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
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
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
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Descifrar datos sensibles antes de retornar a la vista
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) {
                    $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                }
                if (!empty($row['notas_sesion'])) {
                    $row['notas_sesion'] = EncryptionService::decrypt($row['notas_sesion']);
                }
            } catch (\Exception $e) {
                // En caso de que el tag de integridad falle o la clave cambie, 
                // evitamos que toda la aplicación crashee mostrando un error controlado.
                $row['motivo_consulta'] = '⚠️ [Error de Descifrado]';
                $row['notas_sesion'] = '⚠️ [Error de Descifrado]';
            }
        }
        
        return $results;
    }

    /**
     * Obtiene las citas pendientes de hoy para la barra lateral
     */
    public function getCitasHoy(int $idPsicologo): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
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
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        // Descifrar datos sensibles
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) {
                    $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                }
            } catch (\Exception $e) {
                $row['motivo_consulta'] = '⚠️ [Error de Descifrado]';
            }
        }
        
        return $results;
    }

    /**
     * Obtiene las citas pendientes de mañana para enviar recordatorios
     * Retorna citas de todos los psicólogos (para cron job)
     */
    public function getCitasManana(): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $manana = date('Y-m-d', strtotime('+1 day'));
        
        $sql = "
            SELECT 
                c.id_cita, c.fecha, c.hora, c.motivo_consulta,
                u.nombre AS paciente_nombre, u.correo_electronico AS paciente_email,
                p.nombre AS psicologo_nombre, p.correo_electronico AS psicologo_email,
                e.nombre AS especialidad
            FROM citas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            JOIN psicologos p ON c.id_psicologo = p.id_psicologo
            JOIN especialidades e ON p.id_especialidad = e.id_especialidad
            WHERE c.fecha = ?
            AND c.estado = 'pendiente'
            AND u.estado = 'activo'
            AND p.estado = 'activo'
            ORDER BY c.hora ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manana]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) {
                    $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                }
            } catch (\Exception $e) {
                $row['motivo_consulta'] = 'Sin motivo especificado';
            }
        }
        
        return $results;
    }

    /**
     * Obtiene las citas pendientes que empiezan en aproximadamente 1 hora
     * Para cron job que corre cada 15 min
     */
    public function getCitasEn1Hora(): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $ahora = new DateTime();
        $en1Hora = clone $ahora;
        $en1Hora->modify('+1 hour');
        
        // Ventana de 15 min (para cron cada 15 min)
        $ventanaInicio = $en1Hora->format('H:i:00');
        $en1Hora->modify('+15 minutes');
        $ventanaFin = $en1Hora->format('H:i:00');
        $fechaHoy = $ahora->format('Y-m-d');
        
        $sql = "
            SELECT 
                c.id_cita, c.fecha, c.hora, c.motivo_consulta,
                u.nombre AS paciente_nombre, u.correo_electronico AS paciente_email,
                p.nombre AS psicologo_nombre, p.correo_electronico AS psicologo_email,
                e.nombre AS especialidad
            FROM citas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            JOIN psicologos p ON c.id_psicologo = p.id_psicologo
            JOIN especialidades e ON p.id_especialidad = e.id_especialidad
            WHERE c.fecha = ?
            AND c.estado = 'pendiente'
            AND u.estado = 'activo'
            AND p.estado = 'activo'
            AND c.hora BETWEEN ? AND ?
            ORDER BY c.hora ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$fechaHoy, $ventanaInicio, $ventanaFin]);
        
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) {
                    $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                }
            } catch (\Exception $e) {
                $row['motivo_consulta'] = 'Sin motivo especificado';
            }
        }
        
        return $results;
    }

    /**
     * Ejemplo de uso: Guardar una nueva cita aplicando cifrado
     * a los campos sensibles (motivo_consulta y notas_sesion).
     */
    public function insertCita(array $data): bool
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        
        // Cifrar datos médicos sensibles antes del INSERT
        $motivoCifrado = EncryptionService::encrypt($data['motivo_consulta'] ?? '');
        $notasCifradas = EncryptionService::encrypt($data['notas_sesion'] ?? '');
        
        $sql = "
            INSERT INTO citas (id_usuario, id_psicologo, fecha, hora, motivo_consulta, notas_sesion, estado)
            VALUES (?, ?, ?, ?, ?, ?, 'pendiente')
        ";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $data['id_usuario'],
            $data['id_psicologo'],
            $data['fecha'],
            $data['hora'],
            $motivoCifrado,
            $notasCifradas
        ]);
    }

    /**
     * Termina una cita que está en proceso, actualizando duración y notas.
     */
    public function terminarCita(int $idCita, int $duracionMinutos, string $notasSesion): bool
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        
        $notasCifradas = EncryptionService::encrypt($notasSesion);
        
        $sql = "
            UPDATE citas 
            SET estado = 'completada', 
                duracion_minutos = ?, 
                notas_sesion = ?
            WHERE id_cita = ? AND estado = 'en proceso'
        ";
        
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            $duracionMinutos,
            $notasCifradas,
            $idCita
        ]);
    }

    /**
     * Obtiene la cita activa en estado 'en proceso' de la psicóloga (si existe).
     */
    public function getCitaEnProceso(int $idPsicologo): ?array
    {
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, u.nombre AS paciente_nombre
            FROM citas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_psicologo = ? AND c.estado = 'en proceso'
            ORDER BY c.fecha DESC, c.hora DESC
            LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /**
     * Obtiene todas las citas de un usuario (paciente) ordenadas por fecha desc.
     */
    public function getCitasUsuario(int $idUsuario): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT 
                c.id_cita, c.fecha, c.hora, c.estado, c.motivo_consulta,
                p.nombre AS psicologo_nombre, p.foto_perfil, e.nombre AS especialidad,
                p.id_psicologo
            FROM citas c
            JOIN psicologos p ON c.id_psicologo = p.id_psicologo
            JOIN especialidades e ON p.id_especialidad = e.id_especialidad
            WHERE c.id_usuario = ?
            ORDER BY c.fecha DESC, c.hora DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idUsuario]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) {
                    $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                }
            } catch (\Exception $e) {
                $row['motivo_consulta'] = 'Sin motivo especificado';
            }
            // Foto fallback
            if (empty($row['foto_perfil'])) {
                $row['foto_perfil'] = 'https://ui-avatars.com/api/?name=' . urlencode($row['psicologo_nombre']) . '&background=F97316&color=fff&size=128';
            }
        }
        return $results;
    }

    /**
     * Cancela una cita (solo si pertenece al usuario y está pendiente).
     */
    public function cancelarCita(int $idCita, int $idUsuario): bool
    {
        $sql = "UPDATE citas SET estado = 'cancelada' WHERE id_cita = ? AND id_usuario = ? AND estado = 'pendiente'";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idCita, $idUsuario]);
    }

    /**
     * Cancela una cita desde el panel de la psicóloga (solo si le pertenece y está pendiente).
     */
    public function cancelarCitaPsicologa(int $idCita, int $idPsicologo): bool
    {
        $sql = "UPDATE citas SET estado = 'cancelada' WHERE id_cita = ? AND id_psicologo = ? AND estado = 'pendiente'";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$idCita, $idPsicologo]);
    }

    /**
     * Obtiene la información necesaria de una cita antes de cancelarla.
     */
    public function getCitaInfoParaCancelacion(int $idCita, int $idPsicologo): ?array
    {
        $sql = "SELECT id_usuario, fecha, hora FROM citas WHERE id_cita = ? AND id_psicologo = ? AND estado = 'pendiente'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idCita, $idPsicologo]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        return $res ?: null;
    }

    /**
     * Obtiene las citas pendientes de una psicóloga (hoy o futuras).
     */
    public function getCitasPendientesPsicologo(int $idPsicologo): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT 
                c.id_cita, c.fecha, c.hora, c.estado, c.motivo_consulta,
                u.nombre AS paciente_nombre, u.id_usuario
            FROM citas c
            JOIN usuarios u ON c.id_usuario = u.id_usuario
            WHERE c.id_psicologo = ? AND c.estado = 'pendiente' AND c.fecha >= CURRENT_DATE()
            ORDER BY c.fecha ASC, c.hora ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) {
                    $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                }
            } catch (\Exception $e) {
                $row['motivo_consulta'] = 'Sin motivo especificado';
            }
        }
        return $results;
    }

    /**
     * Edita fecha, hora y/o psicólogo de una cita pendiente,
     * SOLO si el nuevo slot está libre.
     */
    public function editarCita(int $idCita, int $idUsuario, string $nuevaFecha, string $nuevaHora, int $nuevoIdPsicologo): bool|string
    {
        // Verificar que la cita pertenece al usuario y está pendiente
        $stmtCheck = $this->db->prepare("SELECT id_cita FROM citas WHERE id_cita = ? AND id_usuario = ? AND estado = 'pendiente'");
        $stmtCheck->execute([$idCita, $idUsuario]);
        if (!$stmtCheck->fetch()) {
            return 'La cita no existe o no se puede editar.';
        }

        // Verificar disponibilidad del nuevo slot (excluyendo la cita actual)
        $stmtOcupada = $this->db->prepare("
            SELECT id_cita FROM citas 
            WHERE id_psicologo = ? AND fecha = ? AND hora = ? AND estado IN ('pendiente','completada','en proceso') AND id_cita != ?
        ");
        $stmtOcupada->execute([$nuevoIdPsicologo, $nuevaFecha, $nuevaHora . ':00', $idCita]);
        if ($stmtOcupada->fetch()) {
            return 'El horario seleccionado no está disponible para ese psicólogo.';
        }

        $sql = "UPDATE citas SET fecha = ?, hora = ?, id_psicologo = ? WHERE id_cita = ? AND id_usuario = ?";
        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([$nuevaFecha, $nuevaHora . ':00', $nuevoIdPsicologo, $idCita, $idUsuario]);
        return $ok ? true : 'Error al actualizar la cita.';
    }

    /**
     * Crea una cita siendo el psicólogo quien agenda (desde su panel).
     * Valida que el slot esté libre antes de insertar.
     *
     * @return true|string  true si OK, mensaje de error si falla
     */
    public function insertCitaPorPsicologo(array $data): bool|string
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';

        // Verificar que el slot no esté ocupado
        $stmtCheck = $this->db->prepare("
            SELECT id_cita FROM citas
            WHERE id_psicologo = ? AND fecha = ? AND hora = ?
              AND estado IN ('pendiente', 'completada', 'en proceso')
        ");
        $hora = (strlen($data['hora']) === 5) ? $data['hora'] . ':00' : $data['hora'];
        $stmtCheck->execute([$data['id_psicologo'], $data['fecha'], $hora]);
        if ($stmtCheck->fetch()) {
            return 'El horario seleccionado ya está ocupado. Elige otra hora.';
        }

        $motivoCifrado = EncryptionService::encrypt($data['motivo_consulta'] ?? '');

        $sql = "
            INSERT INTO citas (id_usuario, id_psicologo, fecha, hora, motivo_consulta, estado)
            VALUES (?, ?, ?, ?, ?, 'pendiente')
        ";
        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([
            $data['id_usuario'],
            $data['id_psicologo'],
            $data['fecha'],
            $hora,
            $motivoCifrado,
        ]);
        return $ok ? true : 'Error al insertar la cita en la base de datos.';
    }

    /**
     * Busca pacientes por nombre o correo (para psicólogas).
     */
    public function buscarPacientes(string $query, int $idPsicologo): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $like = '%' . $query . '%';
        $sql = "
            SELECT DISTINCT
                u.id_usuario, u.nombre, u.correo_electronico, u.grado,
                COUNT(c.id_cita) AS total_citas,
                MAX(c.fecha) AS ultima_cita
            FROM usuarios u
            JOIN citas c ON u.id_usuario = c.id_usuario
            WHERE c.id_psicologo = ?
              AND (u.nombre LIKE ? OR u.correo_electronico LIKE ?)
            GROUP BY u.id_usuario
            ORDER BY u.nombre
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo, $like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Obtiene el historial completo de citas de un usuario con una psicóloga.
     */
    public function getHistorialPaciente(int $idUsuario, int $idPsicologo): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.estado, c.motivo_consulta, c.notas_sesion, c.duracion_minutos
            FROM citas c
            WHERE c.id_usuario = ? AND c.id_psicologo = ?
            ORDER BY c.fecha DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idUsuario, $idPsicologo]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                if (!empty($row['notas_sesion'])) $row['notas_sesion'] = EncryptionService::decrypt($row['notas_sesion']);
            } catch (\Exception $e) {
                $row['motivo_consulta'] = '⚠️ [Error]';
                $row['notas_sesion'] = '⚠️ [Error]';
            }
        }
        return $results;
    }
}

