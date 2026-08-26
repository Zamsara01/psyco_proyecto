<?php
/**
 * Migración: Agregar columna hora_inicio_real a citas para trackear tiempo real de sesión
 * Ejecutar: /opt/lampp/bin/php /opt/lampp/htdocs/psyco_proyecto-davidBackend1/migrate_cita_tiempo.php
 */

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/EnvLoader.php';

EnvLoader::load(__DIR__ . '/.env');

$pdo = \Database::getInstance();

echo "=== Agregando columna hora_inicio_real a citas ===\n\n";

try {
    // Verificar si la columna ya existe
    $stmt = $pdo->query("SHOW COLUMNS FROM citas LIKE 'hora_inicio_real'");
    if ($stmt->fetch()) {
        echo "La columna hora_inicio_real ya existe.\n";
        exit(0);
    }

    $pdo->beginTransaction();

    // Agregar columna
    $sql = "
        ALTER TABLE citas 
        ADD COLUMN hora_inicio_real TIMESTAMP NULL DEFAULT NULL 
        AFTER duracion_minutos
    ";
    $pdo->exec($sql);
    echo "✓ Columna hora_inicio_real agregada\n";

    $pdo->commit();
    echo "\n=== Migración completada ===\n";

} catch (\Exception $e) {
    $pdo->rollBack();
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}