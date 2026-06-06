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

    <!-- Google Fonts: Plus Jakarta Sans + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet"/>

    <!--
        IMPORTANTE: tailwind-config.js DEBE cargarse ANTES del CDN de Tailwind.
        Si se invierte el orden, la configuración de colores/tipografía es ignorada.
    -->
    <script src="<?= URL_BASE ?>public/js/tailwind-config.js"></script>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>

    <!-- Estilos Adicionales / Utilidades -->
    <link rel="stylesheet" href="<?= URL_BASE ?>public/css/tailwind-custom.css">
</head>
<body class="bg-surface text-on-surface min-h-screen flex flex-row font-body-md relative overflow-x-hidden">
    
    <!-- Sidebar unificado para vistas Tailwind -->
    <?php require __DIR__ . '/../partials/tailwind_sidebar.php'; ?>

    <!-- Contenedor Principal (deja espacio para el sidebar fijo w-64) -->
    <div class="flex-grow flex flex-col min-h-screen ml-64 w-[calc(100%-16rem)]">
        
        <!-- Contenido dinámico inyectado por el controlador -->
        <main class="flex-grow flex flex-col relative">
            <?= $content ?>
        </main>

        <!-- Modal de Login (global) -->
        <?php require __DIR__ . '/../partials/login_modal.php'; ?>

        <!-- Modal de Registro (global) -->
        <?php require __DIR__ . '/../partials/register_modal.php'; ?>

        <!-- Modal del Chatbot (global) -->
        <?php require __DIR__ . '/../partials/chatbot_modal.php'; ?>

        <!-- Footer global -->
        <footer class="bg-white border-t border-slate-100 py-4 px-6 text-center mt-auto">
            <p class="text-body-sm text-on-surface-variant">
                &copy; <?= date('Y') ?> <span class="font-semibold text-primary">grupo_psyco</span> — Todos los derechos reservados.
            </p>
        </footer>
    </div>

</body>
</html>