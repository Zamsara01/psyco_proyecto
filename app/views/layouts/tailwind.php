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

    <!-- Anti-FOUC: aplica dark mode ANTES del primer render y previene parpadeo -->
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
            // Ocultar brevemente mientras Tailwind CDN procesa el config con darkMode:'class'
            // Esto evita el parpadeo donde dark:* se aplica con @media antes del config correcto
            document.documentElement.style.visibility = 'hidden';
        })();
    </script>

    <!-- Google Fonts: Plus Jakarta Sans + Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Plus+Jakarta+Sans:wght@400;500;600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:opsz,wght,FILL,GRAD@20..48,100..700,0..1,-50..200&display=swap" rel="stylesheet"/>

    <!--
        TAILWIND PLAY CDN:
        1. El CDN carga primero e inicializa window.tailwind
        2. Inmediatamente después se asigna tailwind.config con darkMode:'class'
           (patrón documentado oficialmente por Tailwind Play CDN)
    -->
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <script>
        // IMPORTANTE: tailwind.config se asigna DESPUÉS del CDN.
        // El CDN detecta este cambio y regenera todos los estilos con darkMode:'class',
        // lo que hace que dark:* clases respondan al toggle de clase en <html>.
        tailwind.config = {
            darkMode: "class",
            safelist: [
                "bg-surface","bg-surface-dim","bg-surface-bright",
                "bg-surface-container-lowest","bg-surface-container-low",
                "bg-surface-container","bg-surface-container-high","bg-surface-container-highest",
                "bg-primary","bg-primary-container","bg-secondary","bg-secondary-container",
                "bg-tertiary","bg-tertiary-container","bg-error","bg-error-container",
                "bg-inverse-surface","bg-background",
                "text-on-surface","text-on-surface-variant","text-on-primary",
                "text-on-primary-container","text-on-secondary","text-on-secondary-container",
                "text-on-tertiary","text-on-tertiary-container","text-on-error",
                "text-on-error-container","text-on-background","text-inverse-on-surface",
                "text-primary","text-secondary","text-tertiary","text-error",
                "text-outline","text-outline-variant",
                "border-outline","border-outline-variant","border-primary",
                "font-body-md","font-body-lg","font-body-sm",
                "font-headline-lg","font-headline-md","font-headline-sm",
                "font-label-md",
                "text-headline-lg","text-headline-md","text-headline-sm",
                "text-body-lg","text-body-md","text-body-sm","text-label-md",
                "overflow-x-hidden",
            ],
            theme: {
                extend: {
                    colors: {
                        "primary": "#0c6e00",
                        "primary-container": "#46b033",
                        "on-primary": "#ffffff",
                        "on-primary-container": "#043c00",
                        "inverse-primary": "#73de5b",
                        "secondary": "#455e90",
                        "secondary-container": "#adc6ff",
                        "on-secondary": "#ffffff",
                        "on-secondary-container": "#385283",
                        "tertiary": "#605e59",
                        "on-tertiary": "#ffffff",
                        "error": "#ba1a1a",
                        "on-error": "#ffffff",
                        "brand-blue": "#2563eb",
                        "brand-blue-dark": "#1d4ed8",
                        "brand-green": "#16a34a",
                        "brand-green-dark": "#15803d",
                        "surface": "transparent",
                        "surface-dim": "#d9dadc",
                        "surface-bright": "#f8f9fb",
                        "surface-container-lowest": "#ffffff",
                        "surface-container-low": "#f3f4f6",
                        "surface-container": "#edeef0",
                        "surface-container-high": "#e7e8ea",
                        "surface-container-highest": "#e1e2e4",
                        "on-surface": "#191c1e",
                        "on-surface-variant": "#584237",
                        "outline": "#8c7164",
                        "outline-variant": "#e0c0b1",
                        "inverse-surface": "#2e3132",
                        "inverse-on-surface": "#f0f1f3",
                        "background": "transparent",
                        "on-background": "#191c1e",
                    },
                    fontFamily: {
                        "body-md": ["Plus Jakarta Sans", "sans-serif"],
                        "body-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "body-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-lg": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-md": ["Plus Jakarta Sans", "sans-serif"],
                        "headline-sm": ["Plus Jakarta Sans", "sans-serif"],
                        "label-md": ["Plus Jakarta Sans", "sans-serif"],
                    },
                    fontSize: {
                        "headline-lg": ["32px", {"lineHeight": "1.2", "fontWeight": "700"}],
                        "headline-md": ["24px", {"lineHeight": "1.3", "fontWeight": "600"}],
                        "headline-sm": ["20px", {"lineHeight": "1.4", "fontWeight": "600"}],
                        "body-lg":  ["18px", {"lineHeight": "1.6", "fontWeight": "400"}],
                        "body-md":  ["16px", {"lineHeight": "1.5", "fontWeight": "400"}],
                        "body-sm":  ["14px", {"lineHeight": "1.5", "fontWeight": "400"}],
                        "label-md": ["12px", {"lineHeight": "1",   "letterSpacing": "0.05em", "fontWeight": "600"}],
                    }
                }
            }
        };
        // Restaurar visibilidad tras el primer repaint con el config correcto
        requestAnimationFrame(() => {
            document.documentElement.style.visibility = '';
        });
    </script>

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