<?php
/**
 * Script para enviar recordatorios de citas para mañana
 * Ejecutar via cron: 0 18 * * * /opt/lampp/bin/php /opt/lampp/htdocs/psyco_proyecto-davidBackend1/send_reminders.php
 * (Se ejecuta a las 18:00 todos los días para recordar citas del día siguiente)
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

$citasManana = $citaModel->getCitasManana();

if (empty($citasManana)) {
    echo date('Y-m-d H:i:s') . " - No hay citas para mañana.\n";
    exit(0);
}

$enviados = 0;
$fallidos = 0;

echo date('Y-m-d H:i:s') . " - Encontradas " . count($citasManana) . " citas para mañana.\n";

foreach ($citasManana as $cita) {
    $okEstudiante = $mailService->sendRecordatorioEstudiante(
        $cita['paciente_email'],
        $cita['paciente_nombre'],
        $cita['psicologo_nombre'],
        $cita['fecha'],
        $cita['hora'],
        $cita['especialidad'],
        $cita['id_cita']
    );
    
    $okPsicologo = $mailService->sendRecordatorioPsicologo(
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
        echo "  ✓ Cita #{$cita['id_cita']} - {$cita['paciente_nombre']} / {$cita['psicologo_nombre']}\n";
    } else {
        $fallidos++;
        echo "  ✗ Cita #{$cita['id_cita']} - FALLO\n";
        if (!$okEstudiante) echo "    - Falló envío a estudiante\n";
        if (!$okPsicologo) echo "    - Falló envío a psicólogo\n";
    }
}

echo date('Y-m-d H:i:s') . " - Completado. Enviados: $enviados, Fallidos: $fallidos\n";