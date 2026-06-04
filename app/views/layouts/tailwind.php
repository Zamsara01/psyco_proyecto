<?php
/**
 * @var string $content El contenido dinámico generado por la vista
 */
$content = $content ?? '';
?>
<!DOCTYPE html>
<html lang="es" class="light">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSYCO - Sistema</title>

    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    
    <!-- Material Symbols -->
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Configuración Unificada de Tailwind -->
    <script src="<?= URL_BASE ?>public/js/tailwind-config.js"></script>

    <!-- Tailwind CSS (CDN) -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Estilos Adicionales / Utilidades -->
    <link rel="stylesheet" href="<?= URL_BASE ?>public/css/tailwind-custom.css">
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-col font-body-md relative overflow-x-hidden">
    
    <!-- Navbar unificado para vistas Tailwind -->
    <?php require __DIR__ . '/../partials/tailwind_navbar.php'; ?>

    <!-- Contenido dinámico inyectado por el controlador -->
    <?= $content ?>

    <!-- Modal de Login (global) -->
    <?php require __DIR__ . '/../partials/login_modal.php'; ?>

    <!-- Modal de Registro (global) -->
    <?php require __DIR__ . '/../partials/register_modal.php'; ?>

    <!-- Footer global -->
    <footer class="bg-white border-t border-slate-100 py-4 px-6 text-center">
        <p class="text-body-sm text-on-surface-variant">
            &copy; <?= date('Y') ?> <span class="font-semibold text-primary">grupo_psyco</span> — Todos los derechos reservados.
        </p>
    </footer>

</body>
</html>