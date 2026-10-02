<?php
/**
 * CitaModel — usa id_paciente (FK a paciente.id_paciente) en lugar de id_usuario.
 * Para obtener nombre/correo del paciente: JOIN paciente p -> JOIN usuario u ON p.id_usuario=u.id_usuario
 */
class CitaModel extends Model
{
    public function getOcupacionPorFecha(): array
    {
        $sql = "SELECT fecha, COUNT(*) AS total_citas FROM citas
                WHERE estado IN ('pendiente','completada') GROUP BY fecha";
        $results = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        $ocupacion = [];
        foreach ($results as $row) $ocupacion[$row['fecha']] = (int)$row['total_citas'];
        return $ocupacion;
    }

    public function getDashboardStats(int $idPsicologo): array
    {
        $exec = function(string $sql, array $params = []) {
            $s = $this->db->prepare($sql); $s->execute($params); return $s->fetchColumn();
        };
        return [
            'sesiones_mes'        => $exec("SELECT COUNT(*) FROM citas WHERE id_psicologo=? AND MONTH(fecha)=MONTH(CURRENT_DATE()) AND YEAR(fecha)=YEAR(CURRENT_DATE()) AND estado!='cancelada'", [$idPsicologo]) ?: 0,
            'pendientes_hoy'      => $exec("SELECT COUNT(*) FROM citas WHERE id_psicologo=? AND estado='pendiente' AND fecha>=CURRENT_DATE()", [$idPsicologo]) ?: 0,
            'nuevos_diagnosticos' => 0,
            'altas_medicas'       => $exec("SELECT COUNT(*) FROM citas WHERE id_psicologo=? AND estado='completada' AND MONTH(fecha)=MONTH(CURRENT_DATE()) AND YEAR(fecha)=YEAR(CURRENT_DATE())", [$idPsicologo]) ?: 0,
            'no_asistidas'        => $exec("SELECT COUNT(*) FROM citas WHERE id_psicologo=? AND asistio=0 AND estado='completada'", [$idPsicologo]) ?: 0,
        ];
    }

    public function getCitasRecientes(int $idPsicologo, int $limit = 10): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.estado, c.motivo_consulta, c.notas_sesion,
                   u.nombre AS paciente_nombre, u.correo_electronico, u.id_usuario,
                   p.id_paciente
            FROM citas c
            JOIN paciente p ON c.id_paciente = p.id_paciente
            JOIN usuario u ON p.id_usuario = u.id_usuario
            WHERE c.id_psicologo = ?
            ORDER BY c.fecha DESC, c.hora DESC
            LIMIT ?
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(1, $idPsicologo, PDO::PARAM_INT);
        $stmt->bindValue(2, $limit,       PDO::PARAM_INT);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                if (!empty($row['notas_sesion']))     $row['notas_sesion']    = EncryptionService::decrypt($row['notas_sesion']);
            } catch (\Exception $e) {
                $row['motivo_consulta'] = '⚠️ [Error de Descifrado]';
                $row['notas_sesion']    = '⚠️ [Error de Descifrado]';
            }
        }
        return $results;
    }

    public function getCitasHoy(int $idPsicologo): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT c.id_cita, c.hora, c.motivo_consulta, u.nombre AS paciente_nombre
            FROM citas c
            JOIN paciente p ON c.id_paciente = p.id_paciente
            JOIN usuario u ON p.id_usuario = u.id_usuario
            WHERE c.id_psicologo=? AND c.fecha=CURRENT_DATE() AND c.estado='pendiente'
            ORDER BY c.hora ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
            } catch (\Exception $e) { $row['motivo_consulta'] = '⚠️ [Error de Descifrado]'; }
        }
        return $results;
    }

    public function getCitasManana(): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $manana = date('Y-m-d', strtotime('+1 day'));
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.motivo_consulta,
                   u.nombre AS paciente_nombre, u.correo_electronico AS paciente_email,
                   up.nombre AS psicologo_nombre, up.correo_electronico AS psicologo_email,
                   e.nombre AS especialidad
            FROM citas c
            JOIN paciente p  ON c.id_paciente  = p.id_paciente
            JOIN usuario u   ON p.id_usuario   = u.id_usuario
            JOIN psicologos ps ON c.id_psicologo = ps.id_psicologo
            JOIN usuario up  ON ps.id_usuario  = up.id_usuario
            JOIN especialidades e ON ps.id_especialidad = e.id_especialidad
            WHERE c.fecha=? AND c.estado='pendiente' AND u.estado='activo' AND up.estado='activo'
              AND NOT EXISTS (SELECT 1 FROM recordatorios r WHERE r.id_cita=c.id_cita AND r.tipo='24h' AND r.estado_envio='enviado')
            ORDER BY c.hora ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$manana]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
            } catch (\Exception $e) { $row['motivo_consulta'] = 'Sin motivo especificado'; }
        }
        return $results;
    }

    public function getCitasEn1Hora(): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.motivo_consulta,
                   u.nombre AS paciente_nombre, u.correo_electronico AS paciente_email,
                   up.nombre AS psicologo_nombre, up.correo_electronico AS psicologo_email,
                   e.nombre AS especialidad
            FROM citas c
            JOIN paciente p  ON c.id_paciente  = p.id_paciente
            JOIN usuario u   ON p.id_usuario   = u.id_usuario
            JOIN psicologos ps ON c.id_psicologo = ps.id_psicologo
            JOIN usuario up  ON ps.id_usuario  = up.id_usuario
            JOIN especialidades e ON ps.id_especialidad = e.id_especialidad
            WHERE c.fecha=CURRENT_DATE()
              AND CONCAT(c.fecha,' ',c.hora) BETWEEN NOW() AND (NOW() + INTERVAL 65 MINUTE)
              AND c.estado='pendiente' AND u.estado='activo' AND up.estado='activo'
              AND NOT EXISTS (SELECT 1 FROM recordatorios r WHERE r.id_cita=c.id_cita AND r.tipo='1h' AND r.estado_envio='enviado')
            ORDER BY c.hora ASC
        ";
        $results = $this->db->query($sql)->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
            } catch (\Exception $e) { $row['motivo_consulta'] = 'Sin motivo especificado'; }
        }
        return $results;
    }

    public function insertCita(array $data): bool
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $motivoCifrado = EncryptionService::encrypt($data['motivo_consulta'] ?? '');
        $notasCifradas = EncryptionService::encrypt($data['notas_sesion']    ?? '');
        $sql = "INSERT INTO citas (id_paciente, id_psicologo, fecha, hora, motivo_consulta, notas_sesion, estado)
                VALUES (?, ?, ?, ?, ?, ?, 'pendiente')";
        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([$data['id_paciente'], $data['id_psicologo'],
                               $data['fecha'], $data['hora'], $motivoCifrado, $notasCifradas]);
        if ($ok) { $this->enviarCorreosConfirmacion((int)$this->db->lastInsertId()); return true; }
        return false;
    }

    private function enviarCorreosConfirmacion(int $idCita): void
    {
        try {
            $sql = "
                SELECT c.fecha, c.hora, c.motivo_consulta,
                       u.nombre AS paciente_nombre, u.correo_electronico AS paciente_email,
                       up.nombre AS psicologo_nombre, up.correo_electronico AS psicologo_email,
                       e.nombre AS especialidad
                FROM citas c
                JOIN paciente p  ON c.id_paciente  = p.id_paciente
                JOIN usuario u   ON p.id_usuario   = u.id_usuario
                JOIN psicologos ps ON c.id_psicologo = ps.id_psicologo
                JOIN usuario up  ON ps.id_usuario  = up.id_usuario
                JOIN especialidades e ON ps.id_especialidad = e.id_especialidad
                WHERE c.id_cita = ?
            ";
            $stmt = $this->db->prepare($sql);
            $stmt->execute([$idCita]);
            $cita = $stmt->fetch(PDO::FETCH_ASSOC);
            if (!$cita) return;

            require_once dirname(__DIR__, 2) . '/core/MailService.php';
            require_once dirname(__DIR__, 2) . '/app/models/RecordatorioModel.php';
            require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';

            $mailService = new MailService();
            $mailService->setRecordatorioModel(new RecordatorioModel());
            $motivo = '';
            try { $motivo = EncryptionService::decrypt($cita['motivo_consulta']); } catch (\Exception $e) {}

            $mailService->sendConfirmacionCitaEstudiante(
                $cita['paciente_email'], $cita['paciente_nombre'],
                $cita['psicologo_nombre'], $cita['fecha'], $cita['hora'],
                $cita['especialidad'], $idCita
            );
            $mailService->sendConfirmacionCitaPsicologo(
                $cita['psicologo_email'], $cita['psicologo_nombre'],
                $cita['paciente_nombre'], $cita['fecha'], $cita['hora'],
                $motivo, $idCita
            );
        } catch (\Exception $e) {
            error_log('[CitaModel] Error enviando confirmación: ' . $e->getMessage());
        }
    }

    public function terminarCita(int $idCita, int $duracionMinutos, string $notasSesion, int $idPsicologo): bool
    {
        $notasCifradas = '';
        if ($notasSesion !== '') {
            require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
            $notasCifradas = EncryptionService::encrypt($notasSesion);
        }
        $sql = "UPDATE citas SET estado='completada', duracion_minutos=?, notas_sesion=?
                WHERE id_cita=? AND id_psicologo=? AND estado='en proceso'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$duracionMinutos, $notasCifradas, $idCita, $idPsicologo]);
        return $stmt->rowCount() > 0;
    }

    public function getCitaEnProceso(int $idPsicologo): ?array
    {
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.hora_inicio_real, u.nombre AS paciente_nombre
            FROM citas c
            JOIN paciente p ON c.id_paciente = p.id_paciente
            JOIN usuario u  ON p.id_usuario  = u.id_usuario
            WHERE c.id_psicologo=? AND c.estado='en proceso'
            ORDER BY c.fecha DESC, c.hora DESC LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getCitaEnProcesoHoy(int $idPsicologo): ?array
    {
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.hora_inicio_real, u.nombre AS paciente_nombre,
                   GREATEST(1, TIMESTAMPDIFF(MINUTE, c.hora_inicio_real, NOW())) AS minutos_en_curso
            FROM citas c
            JOIN paciente p ON c.id_paciente = p.id_paciente
            JOIN usuario u  ON p.id_usuario  = u.id_usuario
            WHERE c.id_psicologo=? AND c.estado='en proceso' AND c.fecha=CURRENT_DATE()
            ORDER BY c.hora_inicio_real ASC LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getCitaProximaHoy(int $idPsicologo): ?array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.motivo_consulta, u.nombre AS paciente_nombre,
                   TIMESTAMPDIFF(MINUTE, CONCAT(c.fecha,' ',c.hora), NOW()) AS minutos_transcurridos
            FROM citas c
            JOIN paciente p ON c.id_paciente = p.id_paciente
            JOIN usuario u  ON p.id_usuario  = u.id_usuario
            WHERE c.id_psicologo=? AND c.fecha=CURRENT_DATE() AND c.estado='pendiente'
              AND TIMESTAMPDIFF(MINUTE, CONCAT(c.fecha,' ',c.hora), NOW()) <= 120
            ORDER BY c.hora ASC LIMIT 1
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        $res = $stmt->fetch(PDO::FETCH_ASSOC);
        if (!$res) return null;
        try {
            if (!empty($res['motivo_consulta'])) $res['motivo_consulta'] = EncryptionService::decrypt($res['motivo_consulta']);
        } catch (\Exception $e) { $res['motivo_consulta'] = ''; }
        return $res;
    }

    public function getCitasUsuario(int $idPaciente): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.estado, c.motivo_consulta,
                   up.nombre AS psicologo_nombre, up.avatar_url AS foto_perfil,
                   e.nombre AS especialidad, ps.id_psicologo
            FROM citas c
            JOIN psicologos ps ON c.id_psicologo = ps.id_psicologo
            JOIN usuario up    ON ps.id_usuario  = up.id_usuario
            JOIN especialidades e ON ps.id_especialidad = e.id_especialidad
            WHERE c.id_paciente = ?
            ORDER BY c.fecha DESC, c.hora DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPaciente]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
            } catch (\Exception $e) { $row['motivo_consulta'] = 'Sin motivo especificado'; }
            if (empty($row['foto_perfil'])) {
                $row['foto_perfil'] = 'https://ui-avatars.com/api/?name=' . urlencode($row['psicologo_nombre']) . '&background=F97316&color=fff&size=128';
            }
        }
        return $results;
    }

    public function cancelarCita(int $idCita, int $idPaciente): bool
    {
        $sql = "UPDATE citas SET estado='cancelada' WHERE id_cita=? AND id_paciente=? AND estado='pendiente'";
        return $this->db->prepare($sql)->execute([$idCita, $idPaciente]);
    }

    public function cancelarCitaPsicologa(int $idCita, int $idPsicologo): bool
    {
        $sql = "UPDATE citas SET estado='cancelada' WHERE id_cita=? AND id_psicologo=? AND estado='pendiente'";
        return $this->db->prepare($sql)->execute([$idCita, $idPsicologo]);
    }

    public function getCitaInfoParaCancelacion(int $idCita, int $idPsicologo): ?array
    {
        $sql = "SELECT id_paciente, fecha, hora FROM citas WHERE id_cita=? AND id_psicologo=? AND estado='pendiente'";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idCita, $idPsicologo]);
        return $stmt->fetch(PDO::FETCH_ASSOC) ?: null;
    }

    public function getCitasPendientesPsicologo(int $idPsicologo): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.estado, c.motivo_consulta,
                   u.nombre AS paciente_nombre, p.id_paciente
            FROM citas c
            JOIN paciente p ON c.id_paciente = p.id_paciente
            JOIN usuario u  ON p.id_usuario  = u.id_usuario
            WHERE c.id_psicologo=? AND c.estado='pendiente' AND c.fecha>=CURRENT_DATE()
            ORDER BY c.fecha ASC, c.hora ASC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
            } catch (\Exception $e) { $row['motivo_consulta'] = 'Sin motivo especificado'; }
        }
        return $results;
    }

    public function editarCita(int $idCita, int $idPaciente, string $nuevaFecha, string $nuevaHora, int $nuevoIdPsicologo): bool|string
    {
        $stmtCheck = $this->db->prepare("SELECT id_cita FROM citas WHERE id_cita=? AND id_paciente=? AND estado='pendiente'");
        $stmtCheck->execute([$idCita, $idPaciente]);
        if (!$stmtCheck->fetch()) return 'La cita no existe o no se puede editar.';

        $stmtOcupada = $this->db->prepare("
            SELECT id_cita FROM citas
            WHERE id_psicologo=? AND fecha=? AND hora=? AND estado IN ('pendiente','completada','en proceso') AND id_cita!=?
        ");
        $stmtOcupada->execute([$nuevoIdPsicologo, $nuevaFecha, $nuevaHora . ':00', $idCita]);
        if ($stmtOcupada->fetch()) return 'El horario seleccionado no está disponible para ese psicólogo.';

        $sql = "UPDATE citas SET fecha=?, hora=?, id_psicologo=? WHERE id_cita=? AND id_paciente=?";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([$nuevaFecha, $nuevaHora . ':00', $nuevoIdPsicologo, $idCita, $idPaciente])
               ? true : 'Error al actualizar la cita.';
    }

    public function insertCitaPorPsicologo(array $data): bool|string
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $hora = (strlen($data['hora']) === 5) ? $data['hora'] . ':00' : $data['hora'];
        $stmtCheck = $this->db->prepare("
            SELECT id_cita FROM citas
            WHERE id_psicologo=? AND fecha=? AND hora=? AND estado IN ('pendiente','completada','en proceso')
        ");
        $stmtCheck->execute([$data['id_psicologo'], $data['fecha'], $hora]);
        if ($stmtCheck->fetch()) return 'El horario seleccionado ya está ocupado. Elige otra hora.';

        $motivoCifrado = EncryptionService::encrypt($data['motivo_consulta'] ?? '');
        $sql = "INSERT INTO citas (id_paciente, id_psicologo, fecha, hora, motivo_consulta, estado)
                VALUES (?, ?, ?, ?, ?, 'pendiente')";
        $stmt = $this->db->prepare($sql);
        $ok = $stmt->execute([$data['id_paciente'], $data['id_psicologo'],
                               $data['fecha'], $hora, $motivoCifrado]);
        if ($ok) { $this->enviarCorreosConfirmacion((int)$this->db->lastInsertId()); return true; }
        return 'Error al insertar la cita en la base de datos.';
    }

    public function buscarPacientes(string $query, int $idPsicologo): array
    {
        $like = '%' . $query . '%';
        $sql = "
            SELECT DISTINCT p.id_paciente, u.id_usuario, u.nombre, u.correo_electronico, p.grado,
                   COUNT(c.id_cita) AS total_citas, MAX(c.fecha) AS ultima_cita
            FROM paciente p
            JOIN usuario u ON p.id_usuario = u.id_usuario
            JOIN citas c   ON c.id_paciente = p.id_paciente
            WHERE c.id_psicologo=? AND (u.nombre LIKE ? OR u.correo_electronico LIKE ?)
            GROUP BY p.id_paciente ORDER BY u.nombre
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPsicologo, $like, $like]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getHistorialPaciente(int $idPaciente, int $idPsicologo): array
    {
        require_once dirname(__DIR__, 2) . '/core/EncryptionService.php';
        $sql = "
            SELECT c.id_cita, c.fecha, c.hora, c.estado, c.motivo_consulta,
                   c.notas_sesion, c.duracion_minutos
            FROM citas c
            WHERE c.id_paciente=? AND c.id_psicologo=?
            ORDER BY c.fecha DESC
        ";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$idPaciente, $idPsicologo]);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($results as &$row) {
            try {
                if (!empty($row['motivo_consulta'])) $row['motivo_consulta'] = EncryptionService::decrypt($row['motivo_consulta']);
                if (!empty($row['notas_sesion']))     $row['notas_sesion']    = EncryptionService::decrypt($row['notas_sesion']);
            } catch (\Exception $e) {
                $row['motivo_consulta'] = '⚠️ [Error]';
                $row['notas_sesion']    = '⚠️ [Error]';
            }
        }
        return $results;
    }

    public function marcarNoAsistio(int $idCita): bool
    {
        return $this->db->prepare("UPDATE citas SET estado='completada', asistio=0 WHERE id_cita=?")->execute([$idCita]);
    }

    public function marcarSiAsistio(int $idCita): bool
    {
        return $this->db->prepare("UPDATE citas SET estado='en proceso', hora_inicio_real=? WHERE id_cita=?")->execute([date('Y-m-d H:i:s'), $idCita]);
    }

    public function setAsistio(int $idCita): bool
    {
        return $this->db->prepare("UPDATE citas SET asistio=1 WHERE id_cita=?")->execute([$idCita]);
    }

    /**
     * Marca un recordatorio insertando una fila en `recordatorios` con el tipo dado.
     * Reemplaza los viejos flags recordatorio_24h / recordatorio_1h.
     */
    public function marcarRecordatorioEnviado(int $idCita, string $tipo): void
    {
        $stmt = $this->db->prepare(
            "INSERT INTO recordatorios (id_cita, tipo, mensaje, fecha_programada, canal, estado_envio, fecha_envio)
             VALUES (?, ?, '', NOW(), 'correo', 'enviado', NOW())"
        );
        $stmt->execute([$idCita, $tipo]);
    }
}
