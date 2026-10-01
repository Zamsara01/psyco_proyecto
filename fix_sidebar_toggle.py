with open('app/views/partials/tailwind_sidebar.php', 'r') as f:
    content = f.read()

# 1. Quitar el botón fijo externo
old_fixed_btn = """<!-- Botón de Alternancia Sidebar/Navbar — siempre visible, esquina superior izquierda -->
<button onclick="toggleLayoutMode()" id="layoutToggleBtn"
    aria-label="Cambiar diseño" title="Alternar menú superior/lateral"
    style="position:fixed; top:12px; left:12px; z-index:9999; background:white; border:1.5px solid #e2e8f0; border-radius:10px; padding:6px 8px; box-shadow:0 2px 8px rgba(0,0,0,0.12); display:flex; align-items:center; gap:4px; cursor:pointer; transition:all 0.2s;"
    onmouseover="this.style.borderColor='#3b82f6'; this.style.color='#3b82f6';"
    onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='';">
    <span class="material-symbols-outlined" id="layoutToggleIcon" style="font-size:18px; line-height:1;">dock_to_bottom</span>
</button>

"""
content = content.replace(old_fixed_btn, '')

# 2. Meter el botón dentro del header del sidebar, junto al botón de cerrar mobile
old_header = """        <!-- Botón cerrar sidebar (solo móvil) -->
        <button onclick="closeSidebar()" aria-label="Cerrar menú"
            class="lg:hidden absolute right-4 p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 dark:text-slate-500 dark:hover:text-slate-300 transition-colors shrink-0">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>"""

new_header = """        <!-- Botón cerrar sidebar (solo móvil) -->
        <button onclick="closeSidebar()" aria-label="Cerrar menú"
            class="lg:hidden absolute right-4 p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-slate-800 dark:text-slate-500 dark:hover:text-slate-300 transition-colors shrink-0">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
        <!-- Botón alternar Sidebar ↔ Navbar (solo escritorio) -->
        <button onclick="toggleLayoutMode()" id="layoutToggleBtn"
            aria-label="Cambiar diseño" title="Alternar menú superior/lateral"
            class="hidden lg:flex absolute right-4 p-1.5 rounded-lg text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-slate-800 transition-colors shrink-0">
            <span class="material-symbols-outlined text-[22px]" id="layoutToggleIcon">dock_to_bottom</span>
        </button>"""

content = content.replace(old_header, new_header)

# 3. Reemplazar el CSS completo de navbar-mode para corregir superposición
old_css_block = """/* ---------- NAVBAR MODE STYLES ---------- */
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
}"""

new_css_block = """/* ---------- NAVBAR MODE STYLES ---------- */
body.navbar-mode {
    flex-direction: column !important;
}

/* El sidebar se convierte en una barra horizontal fija arriba */
body.navbar-mode #app-sidebar {
    position: fixed !important;
    top: 0 !important; left: 0 !important;
    width: 100vw !important;
    height: 60px !important;
    flex-direction: row !important;
    align-items: center !important;
    inset-block: unset !important;
    border-right: none !important;
    border-bottom: 1px solid rgba(148,163,184,0.25) !important;
    padding: 0 1.25rem !important;
    gap: 0 !important;
    transform: none !important;
    overflow: visible !important;
}

/* Cabecera (logo) — ancho fijo, sin borde inferior */
body.navbar-mode #app-sidebar > div:first-child {
    border-bottom: none !important;
    height: 60px !important;
    min-width: max-content !important;
    padding: 0 1rem 0 0 !important;
    margin: 0 !important;
    flex-shrink: 0 !important;
}

/* Botón toggle en navbar-mode: se ubica justo a la derecha del logo */
body.navbar-mode #layoutToggleBtn {
    position: static !important;
    order: 2 !important;
    margin-right: 1rem !important;
}

/* Nav — ocupa el espacio central y pone items en fila */
body.navbar-mode #app-sidebar nav {
    flex: 1 !important;
    flex-direction: row !important;
    align-items: center !important;
    padding: 0 !important;
    overflow: visible !important;
    height: 60px !important;
    min-width: 0 !important;
}
body.navbar-mode #app-sidebar nav > div.space-y-1 {
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 0.125rem !important;
    height: 60px !important;
    flex-wrap: nowrap !important;
}
body.navbar-mode #app-sidebar nav > div.space-y-1 > a,
body.navbar-mode #app-sidebar nav > div.space-y-1 > button,
body.navbar-mode #app-sidebar nav > div.space-y-1 > div {
    width: auto !important;
    height: 38px !important;
    padding: 0 0.75rem !important;
    margin: 0 !important;
    display: flex !important;
    align-items: center !important;
    white-space: nowrap !important;
    border-radius: 0.5rem !important;
}

/* Dropdown en navbar */
body.navbar-mode #misRecursosDropdown { position: relative !important; }
body.navbar-mode #misRecursosMenu {
    position: absolute !important;
    top: calc(100% + 4px) !important;
    left: 0 !important;
    background: white !important;
    border-radius: 0.75rem !important;
    box-shadow: 0 8px 24px rgba(0,0,0,0.12) !important;
    min-width: 180px !important;
    padding: 0.4rem !important;
    z-index: 999 !important;
}
.dark body.navbar-mode #misRecursosMenu { background: #1e293b !important; }
body.navbar-mode #misRecursosMenu a {
    width: 100% !important;
    margin: 0 !important;
    height: auto !important;
    padding: 0.5rem 0.75rem !important;
}

/* Ocultar bloque decorativo inferior */
body.navbar-mode #app-sidebar nav > div.mt-auto { display: none !important; }

/* Footer (info de usuario) — al final a la derecha */
body.navbar-mode #app-sidebar > div:last-child {
    border-top: none !important;
    padding: 0 !important;
    margin-left: auto !important;
    display: flex !important;
    flex-direction: row !important;
    align-items: center !important;
    gap: 0.5rem !important;
    flex-shrink: 0 !important;
    height: 60px !important;
}
body.navbar-mode #app-sidebar > div:last-child > div.flex.items-center.gap-3 { display: none !important; } /* Ocultar bloque nombre/avatar */
body.navbar-mode #app-sidebar > div:last-child button,
body.navbar-mode #app-sidebar > div:last-child a {
    margin: 0 !important;
    width: auto !important;
    padding: 0.4rem 0.75rem !important;
    white-space: nowrap !important;
    border-radius: 0.5rem !important;
    font-size: 0.8rem !important;
}
body.navbar-mode #app-sidebar > div:last-child .space-y-2 {
    display: flex !important;
    flex-direction: row !important;
    gap: 0.4rem !important;
}
body.navbar-mode #app-sidebar > div:last-child .space-y-2 > * { margin: 0 !important; }

/* Contenido principal: quitar margen izquierdo y agregar padding-top */
body.navbar-mode #main-content {
    margin-left: 0 !important;
    width: 100% !important;
    padding-top: 60px !important;
}"""

# Reemplazar también el CSS del boton reposicionado que agregamos antes
old_btn_css = """/* En navbar-mode el botón toggle se reposiciona dentro de la barra */
body.navbar-mode #layoutToggleBtn {
    position: fixed !important;
    top: 18px !important;
    left: auto !important;
    right: 12px !important; /* Lo movemos a la derecha en navbar-mode */
    z-index: 9999 !important;
}

"""
content = content.replace(old_btn_css, '')
content = content.replace(old_css_block, new_css_block)

with open('app/views/partials/tailwind_sidebar.php', 'w') as f:
    f.write(content)

print('Done. Button moved inside sidebar header, navbar CSS fixed.')
