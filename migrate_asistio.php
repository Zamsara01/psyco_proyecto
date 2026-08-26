<?php
/**
 * Migración: Agregar columna asistio a citas para trackear asistencia
 * Ejecutar: /opt/lampp/bin/php /opt/lampp/htdocs/psyco_proyecto-davidBackend1/migrate_asistio.php
 */

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/EnvLoader.php';

EnvLoader::load(__DIR__ . '/.env');

$pdo = \Database::getInstance();

echo "=== Agregando columna asistio a citas ===\n\n";

try {
    // Verificar si la columna ya existe
    $stmt = $pdo->query("SHOW COLUMNS FROM citas LIKE 'asistio'");
    if ($stmt->fetch()) {
        echo "La columna asistio ya existe.\n";
        exit(0);
    }

    $pdo->beginTransaction();

    // Agregar columna
    $sql = "
        ALTER TABLE citas 
        ADD COLUMN asistio TINYINT(1) NULL DEFAULT NULL 
        AFTER estado
    ";
    $pdo->exec($sql);
    echo "✓ Columna asistio agregada\n";

    $pdo->commit();
    echo "\n=== Migración completada ===\n";

} catch (\Exception $e) {
    $pdo->rollBack();
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}