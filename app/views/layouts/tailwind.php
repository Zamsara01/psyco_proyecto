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

    <!-- Anti-FOUC: aplica dark mode ANTES del primer render (sin parpadeo) -->
    <script>
        (function() {
            const saved = localStorage.getItem('psyco-theme');
            const prefersDark = window.matchMedia('(prefers-color-scheme: dark)').matches;
            if (saved === 'dark' || (!saved && prefersDark)) {
                document.documentElement.classList.add('dark');
                document.documentElement.classList.remove('light');
            } else {
                document.documentElement.classList.add('light');
                document.documentElement.classList.remove('dark');
            }
            // Con CSS compilado no es necesario ocultar la página —
            // el <link rel="stylesheet"> es síncrono y aplica antes del primer paint.
        })();
    </script>

    <!-- Google Fonts: Plus Jakarta Sans + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet"/>

    <!--
        TAILWIND CSS COMPILADO (Tailwind CLI v4)
        Generado con: npm run build
        Fuente: public/css/tailwind-input.css → public/css/tailwind.css
    -->
    <link rel="stylesheet" href="<?= URL_BASE ?>public/css/tailwind.css">

    <!-- Estilos adicionales / Utilidades del proyecto -->
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
        <footer class="bg-white/70 dark:bg-slate-900/80 backdrop-blur-sm border-t border-slate-200/60 dark:border-slate-700/60 py-4 px-6 text-center mt-auto">
            <p class="text-body-sm text-on-surface-variant dark:text-slate-400">
                &copy; <?= date('Y') ?> <span class="font-semibold text-primary dark:text-emerald-400">grupo_psyco</span> — Todos los derechos reservados.
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

// ── Dark Mode Toggle ─────────────────────────────────────────────
function toggleDarkMode() {
    const html = document.documentElement;
    const isDark = html.classList.contains('dark');

    // Cambiar clases en <html>
    if (isDark) {
        html.classList.remove('dark');
        html.classList.add('light');
        localStorage.setItem('psyco-theme', 'light');
    } else {
        html.classList.add('dark');
        html.classList.remove('light');
        localStorage.setItem('psyco-theme', 'dark');
    }

    // Forzar re-evaluación de estilos de Tailwind (Play CDN)
    if (window.tailwind && typeof window.tailwind.refresh === 'function') {
        window.tailwind.refresh();
    }

    // El estado NUEVO es el opuesto de isDark
    const nowDark = !isDark;

    // Actualizar todos los íconos/labels del toggle (puede haber varios en el DOM)
    _syncDarkModeUI(nowDark);
}

function _syncDarkModeUI(isDarkNow) {
    // Si está en oscuro: el botón ofrece ir al claro → ícono 'light_mode'
    // Si está en claro:  el botón ofrece ir al oscuro → ícono 'dark_mode'
    document.querySelectorAll('[id="darkModeIcon"]').forEach(el => {
        el.textContent = isDarkNow ? 'light_mode' : 'dark_mode';
    });
    document.querySelectorAll('[id="darkModeLabel"]').forEach(el => {
        el.textContent = isDarkNow ? 'Modo claro' : 'Modo oscuro';
    });
}

// Sincronizar ícono al cargar la página
document.addEventListener('DOMContentLoaded', () => {
    const isDarkNow = document.documentElement.classList.contains('dark');
    _syncDarkModeUI(isDarkNow);
});
</script>

</body>
</html>