<?php
$pacienteNombre = htmlspecialchars($paciente['nombre'] ?? 'Paciente Desconocido');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Historial Clínico - <?= $pacienteNombre ?></title>
    <style>
        body {
            font-family: Arial, sans-serif;
            color: #333;
            line-height: 1.6;
            margin: 0;
            padding: 20px;
        }
        .header {
            text-align: center;
            border-bottom: 2px solid #6b21a8;
            padding-bottom: 10px;
            margin-bottom: 30px;
        }
        .header h1 {
            margin: 0;
            color: #6b21a8;
            font-size: 24px;
        }
        .header p {
            margin: 5px 0 0 0;
            font-size: 14px;
            color: #666;
        }
        .info-paciente {
            background-color: #f3f4f6;
            padding: 15px;
            border-radius: 8px;
            margin-bottom: 30px;
        }
        .info-paciente p {
            margin: 5px 0;
            font-weight: bold;
        }
        .nota {
            border: 1px solid #e5e7eb;
            padding: 15px;
            margin-bottom: 20px;
            border-radius: 8px;
            page-break-inside: avoid;
        }
        .nota-header {
            display: flex;
            justify-content: space-between;
            border-bottom: 1px solid #e5e7eb;
            padding-bottom: 10px;
            margin-bottom: 10px;
        }
        .nota-titulo {
            font-size: 16px;
            font-weight: bold;
            color: #1f2937;
            margin: 0;
        }
        .nota-meta {
            font-size: 12px;
            color: #6b7280;
        }
        .nota-tipo {
            display: inline-block;
            background-color: #e0e7ff;
            color: #4338ca;
            padding: 2px 8px;
            border-radius: 12px;
            font-size: 11px;
            text-transform: uppercase;
            font-weight: bold;
            margin-top: 5px;
        }
        .nota-contenido {
            font-size: 14px;
            white-space: pre-wrap;
            color: #4b5563;
        }
        .footer {
            margin-top: 50px;
            text-align: center;
            font-size: 12px;
            color: #9ca3af;
            border-top: 1px solid #e5e7eb;
            padding-top: 10px;
        }
        @media print {
            body { padding: 0; }
            .btn-imprimir { display: none; }
        }
        .btn-imprimir {
            display: block;
            width: 200px;
            margin: 0 auto 30px;
            padding: 10px;
            background-color: #6b21a8;
            color: white;
            text-align: center;
            text-decoration: none;
            border-radius: 8px;
            font-weight: bold;
            border: none;
            cursor: pointer;
        }
    </style>
</head>
<body>

    <button class="btn-imprimir" onclick="window.print()">🖨️ Imprimir Historial</button>

    <div class="header">
        <h1>Historial Clínico Psicológico</h1>
        <p>Documento confidencial generado el <?= htmlspecialchars($fecha) ?></p>
    </div>

    <div class="info-paciente">
        <p>Paciente: <span style="font-weight: normal;"><?= $pacienteNombre ?></span></p>
        <p>Impreso por: <span style="font-weight: normal;"><?= htmlspecialchars($_SESSION['user']['nombre'] ?? '') ?></span></p>
    </div>

    <h3>Registro de Notas y Evolución</h3>

    <?php if (empty($notas)): ?>
        <p>No hay notas registradas para este paciente.</p>
    <?php else: ?>
        <?php foreach ($notas as $nota): ?>
            <div class="nota">
                <div class="nota-header">
                    <div>
                        <h4 class="nota-titulo"><?= htmlspecialchars($nota['titulo']) ?></h4>
                        <span class="nota-tipo"><?= htmlspecialchars($nota['tipo_nota'] ?? 'general') ?></span>
                    </div>
                    <div class="nota-meta" style="text-align: right;">
                        <?= htmlspecialchars(substr($nota['fecha_creacion'], 0, 16)) ?><br>
                        <span style="font-weight: bold; color: #4338ca;">Dr/a. <?= htmlspecialchars($nota['psicologo_nombre'] ?? '') ?></span>
                    </div>
                </div>
                <div class="nota-contenido"><?= htmlspecialchars($nota['contenido']) ?></div>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>

    <div class="footer">
        Este documento es estrictamente confidencial y de uso exclusivo para el profesional tratante y el paciente.<br>
        Sistema de Gestión Psicológica
    </div>

    <script>
        // Imprimir automáticamente al abrir la página
        window.onload = function() {
            setTimeout(() => {
                window.print();
            }, 500);
        };
    </script>
</body>
</html>
