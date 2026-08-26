<?php
/**
 * Script para enviar recordatorios de citas en 1 hora
 * Ejecutar via cron cada 15 min: star/15 * * * * /opt/lampp/bin/php /opt/lampp/htdocs/psyco_proyecto-davidBackend1/send_reminders_1h.php
 */

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/EnvLoader.php';
require_once __DIR__ . '/core/MailService.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/app/models/CitaModel.php';
require_once __DIR__ . '/app/models/RecordatorioModel.php';

EnvLoader::load(__DIR__ . '/.env');

$citaModel = new CitaModel();
$recordatorioModel = new RecordatorioModel();
$mailService = new MailService();
$mailService->setRecordatorioModel($recordatorioModel);

$citasEn1Hora = $citaModel->getCitasEn1Hora();

if (empty($citasEn1Hora)) {
    exit(0); // Silencioso si no hay citas
}

$enviados = 0;
$fallidos = 0;

foreach ($citasEn1Hora as $cita) {
    $okEstudiante = $mailService->sendRecordatorio1HoraEstudiante(
        $cita['paciente_email'],
        $cita['paciente_nombre'],
        $cita['psicologo_nombre'],
        $cita['fecha'],
        $cita['hora'],
        $cita['especialidad'],
        $cita['id_cita']
    );
    
    $okPsicologo = $mailService->sendRecordatorio1HoraPsicologo(
        $cita['psicologo_email'],
        $cita['psicologo_nombre'],
        $cita['paciente_nombre'],
        $cita['fecha'],
        $cita['hora'],
        $cita['motivo_consulta'],
        $cita['id_cita']
    );
    
    if ($okEstudiante && $okPsicologo) {
        $enviados++;
    } else {
        $fallidos++;
    }
}

// Log solo si hay actividad
if ($enviados > 0 || $fallidos > 0) {
    error_log("[Reminders 1h] Enviados: $enviados, Fallidos: $fallidos");
}