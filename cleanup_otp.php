<?php
/**
 * Script para limpiar códigos OTP expirados
 * Ejecutar via cron cada hora: 0 * * * * /opt/lampp/bin/php /opt/lampp/htdocs/psyco_proyecto-davidBackend1/cleanup_otp.php
 */

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/EnvLoader.php';
require_once __DIR__ . '/core/Model.php';
require_once __DIR__ . '/app/models/OtpModel.php';

EnvLoader::load(__DIR__ . '/.env');

$otpModel = new OtpModel();

$eliminados = $otpModel->limpiarExpirados();

if ($eliminados > 0) {
    echo date('Y-m-d H:i:s') . " - Eliminados $eliminados códigos OTP expirados.\n";
}