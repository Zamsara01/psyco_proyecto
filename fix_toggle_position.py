with open('app/views/partials/tailwind_sidebar.php', 'r') as f:
    content = f.read()

# 1. Quitar el botón que pusimos en la cabecera del logo
old_btn_in_header = """        <!-- Botón alternar Sidebar ↔ Navbar (solo escritorio) -->
        <button onclick="toggleLayoutMode()" id="layoutToggleBtn"
            aria-label="Cambiar diseño" title="Alternar menú superior/lateral"
            class="hidden lg:flex absolute right-4 p-1.5 rounded-lg text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-slate-800 transition-colors shrink-0">
            <span class="material-symbols-outlined text-[22px]" id="layoutToggleIcon">dock_to_bottom</span>
        </button>"""
content = content.replace(old_btn_in_header, '')

# 2. Colocar el botón justo al lado del botón de Modo oscuro (usuario logueado)
old_dark_logged = """            <!-- Toggle dark mode -->
            <button onclick="toggleDarkMode()"
                class="flex items-center gap-2 w-full px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors mb-2">
                <span class="material-symbols-outlined text-[18px]" id="darkModeIcon">dark_mode</span>
                <span id="darkModeLabel">Modo oscuro</span>
            </button>"""

new_dark_logged = """            <!-- Toggle dark mode + Toggle layout (en fila) -->
            <div class="flex items-center gap-2 mb-2">
                <button onclick="toggleDarkMode()"
                    class="flex flex-1 items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                    <span class="material-symbols-outlined text-[18px]" id="darkModeIcon">dark_mode</span>
                    <span id="darkModeLabel">Modo oscuro</span>
                </button>
                <button onclick="toggleLayoutMode()" id="layoutToggleBtn"
                    aria-label="Alternar diseño" title="Cambiar entre Navbar y Sidebar"
                    class="flex items-center justify-center p-2 text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-slate-800 rounded-xl transition-colors shrink-0 border border-slate-200 dark:border-slate-700">
                    <span class="material-symbols-outlined text-[18px]" id="layoutToggleIcon">dock_to_bottom</span>
                </button>
            </div>"""

content = content.replace(old_dark_logged, new_dark_logged)

# 3. Hacer lo mismo para el bloque de invitado (sin sesión)
old_dark_guest = """                <!-- Toggle dark mode -->
                <button onclick="toggleDarkMode()"
                    class="flex items-center gap-2 w-full px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                    <span class="material-symbols-outlined text-[18px]" id="darkModeIcon">dark_mode</span>
                    <span id="darkModeLabel">Modo oscuro</span>
                </button>"""

new_dark_guest = """                <!-- Toggle dark mode + Toggle layout (en fila) -->
                <div class="flex items-center gap-2">
                    <button onclick="toggleDarkMode()"
                        class="flex flex-1 items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-500 dark:text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 rounded-xl transition-colors">
                        <span class="material-symbols-outlined text-[18px]" id="darkModeIcon">dark_mode</span>
                        <span id="darkModeLabel">Modo oscuro</span>
                    </button>
                    <button onclick="toggleLayoutMode()" id="layoutToggleBtn"
                        aria-label="Alternar diseño" title="Cambiar entre Navbar y Sidebar"
                        class="flex items-center justify-center p-2 text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-blue-400 hover:bg-blue-50 dark:hover:bg-slate-800 rounded-xl transition-colors shrink-0 border border-slate-200 dark:border-slate-700">
                        <span class="material-symbols-outlined text-[18px]" id="layoutToggleIcon">dock_to_bottom</span>
                    </button>
                </div>"""

content = content.replace(old_dark_guest, new_dark_guest)

with open('app/views/partials/tailwind_sidebar.php', 'w') as f:
    f.write(content)

print('Toggle button placed next to dark mode button.')
