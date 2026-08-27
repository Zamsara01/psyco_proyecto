<?php
/**
 * Migración: Agregar columna jornada a disponibilidad_psicologos
 * Ejecutar: /opt/lampp/bin/php /opt/lampp/htdocs/psyco_proyecto-davidBackend1/migrate_jornada.php
 */

require_once __DIR__ . '/core/Database.php';
require_once __DIR__ . '/core/EnvLoader.php';

EnvLoader::load(__DIR__ . '/.env');

$pdo = \Database::getInstance();

echo "=== Agregando columna jornada a disponibilidad_psicologos ===\n\n";

try {
    // Verificar si la columna ya existe
    $stmt = $pdo->query("SHOW COLUMNS FROM disponibilidad_psicologos LIKE 'jornada'");
    if ($stmt->fetch()) {
        echo "La columna jornada ya existe.\n";
        exit(0);
    }

    $pdo->beginTransaction();

    // 1. Agregar columna jornada (VARCHAR para guardar formato "08:00-14:00")
    $sql = "
        ALTER TABLE disponibilidad_psicologos 
        ADD COLUMN jornada VARCHAR(20) NULL DEFAULT NULL 
        AFTER hora_fin
    ";
    $pdo->exec($sql);
    echo "✓ Columna jornada agregada\n";

    // 2. Migrar datos existentes: combinar hora_inicio y hora_fin en jornada
    $stmt = $pdo->query("
        UPDATE disponibilidad_psicologos 
        SET jornada = CONCAT(TIME_FORMAT(hora_inicio, '%H:%i'), '-', TIME_FORMAT(hora_fin, '%H:%i'))
        WHERE jornada IS NULL
    ");
    echo "✓ Datos migrados: " . $stmt->rowCount() . " registros actualizados\n";

    // 3. Agregar constraint UNIQUE para permitir solo 1 jornada por día por psicólogo
    $pdo->exec("
        ALTER TABLE disponibilidad_psicologos 
        ADD UNIQUE KEY uk_psicologo_dia (id_psicologo, dia_semana, activo)
    ");
    echo "✓ Constraint UNIQUE agregado (1 jornada por día por psicólogo)\n";

    $pdo->commit();
    echo "\n=== Migración completada exitosamente ===\n";

} catch (\Exception $e) {
    $pdo->rollBack();
    echo "\n✗ Error: " . $e->getMessage() . "\n";
    exit(1);
}