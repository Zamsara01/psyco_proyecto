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
        IMPORTANTE: El runtime de Tailwind se carga PRIMERO para crear el objeto global `tailwind`.
        Luego tailwind-config.js asigna la configuración personalizada.
        (Usando versión local porque no hay acceso al CDN)
    -->
    <script src="<?= URL_BASE ?>public/js/tailwindcss.js"></script>
    <script src="<?= URL_BASE ?>public/js/tailwind-config.js"></script>

    <!-- Estilos Adicionales / Utilidades -->
    <link rel="stylesheet" href="<?= URL_BASE ?>public/css/tailwind-custom.css">
</head>
<body class="text-on-surface min-h-screen flex flex-row font-body-md relative overflow-x-hidden">
    
    <!-- Overlay para móvil (cierra el sidebar al tocar fuera) -->
    <div id="sidebar-overlay"
         class="fixed inset-0 bg-black/40 backdrop-blur-sm z-30 hidden lg:hidden"
         onclick="closeSidebar()"
         aria-hidden="true"></div>

    <!-- Sidebar unificado para vistas Tailwind -->
    <?php require __DIR__ . '/../partials/tailwind_sidebar.php'; ?>

    <!-- Contenedor Principal -->
    <div id="main-content" class="flex-grow flex flex-col min-h-screen w-full lg:ml-64 lg:w-[calc(100%-16rem)] transition-all duration-300">
        
        <!-- Contenido dinámico inyectado por el controlador -->
        <main class="flex-grow flex flex-col relative">
            <?= $content ?>
        </main>

        <!-- Modal de Login (global) -->
        <?php require __DIR__ . '/../partials/login_modal.php'; ?>

        <!-- Modal de Registro (global) -->
        <?php require __DIR__ . '/../partials/register_modal.php'; ?>

        <!-- Modal OTP (solo si hay verificación pendiente) -->
        <?php if (isset($_SESSION['temp_user_id'])): ?>
            <?php require __DIR__ . '/../partials/otp_modal.php'; ?>
        <?php endif; ?>

        <!-- Modal del Chatbot (global) -->
        <?php require __DIR__ . '/../partials/chatbot_modal.php'; ?>

        <!-- Modal: Requiere inicio de sesión (global) -->
        <?php require __DIR__ . '/../partials/login_required_modal.php'; ?>

        <!-- Footer global -->
        <footer class="bg-white/70 backdrop-blur-sm border-t border-slate-200/60 py-4 px-6 text-center mt-auto">
            <p class="text-body-sm text-on-surface-variant">
                &copy; <?= date('Y') ?> <span class="font-semibold text-primary">grupo_psyco</span> — Todos los derechos reservados.
            </p>
        </footer>
    </div>

<script>
// ── Sidebar responsive ──────────────────────────────────────────
function openSidebar() {
    const sidebar  = document.getElementById('app-sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    if (sidebar)  sidebar.classList.remove('-translate-x-full');
    if (overlay)  overlay.classList.remove('hidden');
    document.body.style.overflow = 'hidden';
}
function closeSidebar() {
    const sidebar  = document.getElementById('app-sidebar');
    const overlay  = document.getElementById('sidebar-overlay');
    if (sidebar)  sidebar.classList.add('-translate-x-full');
    if (overlay)  overlay.classList.add('hidden');
    document.body.style.overflow = '';
}

// En pantallas grandes siempre mostrar sidebar
function handleResize() {
    if (window.innerWidth >= 1024) {
        const sidebar = document.getElementById('app-sidebar');
        const overlay = document.getElementById('sidebar-overlay');
        if (sidebar) sidebar.classList.remove('-translate-x-full');
        if (overlay) overlay.classList.add('hidden');
        document.body.style.overflow = '';
    } else {
        // Colapsar en móvil si se reduce la ventana
        const sidebar = document.getElementById('app-sidebar');
        if (sidebar) sidebar.classList.add('-translate-x-full');
    }
}

window.addEventListener('resize', handleResize);
// Inicializar estado
handleResize();
</script>

</body>
</html>