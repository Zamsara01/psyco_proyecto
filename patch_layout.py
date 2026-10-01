import re

with open('app/views/partials/tailwind_sidebar.php', 'r') as f:
    content = f.read()

# 1. Agregar el botón de toggle al lado del logo
logo_area = """        <a href="<?= URL_BASE ?>" class="flex items-center justify-center gap-3 min-w-0">
            <img alt="PSYCO Logo" class="h-11 w-auto object-contain shrink-0" src="<?= URL_BASE ?>public/img/psyco.png"/>
            <span class="text-2xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent hover:opacity-90 transition-opacity truncate">PSYCO</span>
        </a>"""

btn_toggle = """
        <!-- Botón alternar diseño (Navbar/Sidebar) -->
        <button onclick="toggleLayoutMode()" aria-label="Cambiar diseño" title="Alternar menú superior/lateral"
            class="hidden lg:flex absolute right-12 p-1.5 rounded-lg text-slate-400 hover:text-blue-600 transition-colors border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm z-50">
            <span class="material-symbols-outlined text-[18px]" id="layoutToggleIcon">dock_to_bottom</span>
        </button>
"""

content = content.replace(logo_area, logo_area + btn_toggle)

# 2. Agregar CSS y JS al final del archivo
css_js = """
<!-- ══════════════ SCRIPT Y ESTILOS PARA NAVBAR MODE ══════════════ -->
<style>
/* ---------- NAVBAR MODE STYLES ---------- */
body.navbar-mode {
    flex-direction: column !important;
}
body.navbar-mode #app-sidebar {
    width: 100vw !important;
    height: 76px !important;
    flex-direction: row !important;
    align-items: center !important;
    border-right: none !important;
    border-bottom: 1px solid rgba(148, 163, 184, 0.2) !important;
    padding: 0 2rem !important;
    position: fixed !important;
    top: 0 !important;
    left: 0 !important;
    z-index: 50 !important;
    transform: none !important;
}
body.navbar-mode #app-sidebar > div:first-child { 
    border-bottom: none !important;
    height: 100% !important;
    padding: 0 !important;
    margin-right: 2rem !important;
}
body.navbar-mode #app-sidebar nav {
    flex-direction: row !important;
    align-items: center !important;
    padding: 0 !important;
    overflow: visible !important;
    height: 100% !important;
}
body.navbar-mode #app-sidebar nav > div.space-y-1 {
    display: flex !important;
    flex-direction: row !important;
    gap: 0.25rem !important;
    height: 100% !important;
    align-items: center !important;
}
body.navbar-mode #app-sidebar nav > div.space-y-1 > a,
body.navbar-mode #app-sidebar nav > div.space-y-1 > button,
body.navbar-mode #app-sidebar nav > div.space-y-1 > div {
    width: auto !important;
    height: 42px !important;
    padding: 0 1rem !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
    white-space: nowrap !important;
}
/* Dropdowns inside navbar */
body.navbar-mode #misRecursosDropdown {
    position: relative !important;
}
body.navbar-mode #misRecursosDropdown > button {
    height: 100% !important;
}
body.navbar-mode #misRecursosMenu {
    position: absolute !important;
    top: calc(100% + 5px) !important;
    left: 0 !important;
    background: white !important;
    border-radius: 0.75rem !important;
    box-shadow: 0 10px 25px -5px rgba(0,0,0,0.1) !important;
    min-width: 200px !important;
    padding: 0.5rem !important;
    z-index: 60 !important;
}
.dark body.navbar-mode #misRecursosMenu {
    background: #1e293b !important;
}
body.navbar-mode #misRecursosMenu a {
    width: 100% !important;
    margin: 0 !important;
}
/* Hide bottom decorative box */
body.navbar-mode #app-sidebar nav > div.mt-auto {
    display: none !important;
}
/* Footer (User info & logout) */
body.navbar-mode #app-sidebar > div:last-child {
    border-top: none !important;
    padding: 0 !important;
    margin-left: auto !important;
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 1rem !important;
}
body.navbar-mode #app-sidebar > div:last-child > div.flex.items-center {
    margin: 0 !important;
    padding: 0 !important;
}
body.navbar-mode #app-sidebar > div:last-child button,
body.navbar-mode #app-sidebar > div:last-child a {
    margin: 0 !important;
    width: auto !important;
    padding: 0.5rem 1rem !important;
    white-space: nowrap !important;
}
body.navbar-mode #app-sidebar > div:last-child .space-y-2 {
    display: flex !important;
    flex-direction: row !important;
    gap: 0.5rem !important;
}
body.navbar-mode #app-sidebar > div:last-child .space-y-2 > * {
    margin: 0 !important;
}

/* Adjust Main Content to not overlap */
body.navbar-mode #main-content {
    margin-left: 0 !important;
    width: 100% !important;
    padding-top: 76px !important; /* Offset for fixed navbar */
}
</style>

<script>
function toggleLayoutMode() {
    const isNavbar = document.body.classList.contains('navbar-mode');
    if (isNavbar) {
        document.body.classList.remove('navbar-mode');
        localStorage.setItem('psyco-layout', 'sidebar');
        document.getElementById('layoutToggleIcon').textContent = 'dock_to_bottom';
    } else {
        document.body.classList.add('navbar-mode');
        localStorage.setItem('psyco-layout', 'navbar');
        document.getElementById('layoutToggleIcon').textContent = 'dock_to_left';
    }
}
document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('psyco-layout') === 'navbar') {
        document.body.classList.add('navbar-mode');
        const icon = document.getElementById('layoutToggleIcon');
        if(icon) icon.textContent = 'dock_to_left';
    }
});
</script>
"""

content = content + "\n" + css_js

with open('app/views/partials/tailwind_sidebar.php', 'w') as f:
    f.write(content)

print('Navbar toggle functionality added.')
