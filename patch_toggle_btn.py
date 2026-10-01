with open('app/views/partials/tailwind_sidebar.php', 'r') as f:
    content = f.read()

# Quitar el botón viejo que no se ve
old_btn = """
        <!-- Botón alternar diseño (Navbar/Sidebar) -->
        <button onclick="toggleLayoutMode()" aria-label="Cambiar diseño" title="Alternar menú superior/lateral"
            class="hidden lg:flex absolute right-12 p-1.5 rounded-lg text-slate-400 hover:text-blue-600 transition-colors border border-slate-200 dark:border-slate-700 bg-white dark:bg-slate-800 shadow-sm z-50">
            <span class="material-symbols-outlined text-[18px]" id="layoutToggleIcon">dock_to_bottom</span>
        </button>
"""
content = content.replace(old_btn, '')

# Agregar el botón fijo en la esquina superior izquierda ANTES del <aside
new_btn = """<!-- Botón de Alternancia Sidebar/Navbar — siempre visible, esquina superior izquierda -->
<button onclick="toggleLayoutMode()" id="layoutToggleBtn"
    aria-label="Cambiar diseño" title="Alternar menú superior/lateral"
    style="position:fixed; top:12px; left:12px; z-index:9999; background:white; border:1.5px solid #e2e8f0; border-radius:10px; padding:6px 8px; box-shadow:0 2px 8px rgba(0,0,0,0.12); display:flex; align-items:center; gap:4px; cursor:pointer; transition:all 0.2s;"
    onmouseover="this.style.borderColor='#3b82f6'; this.style.color='#3b82f6';"
    onmouseout="this.style.borderColor='#e2e8f0'; this.style.color='';">
    <span class="material-symbols-outlined" id="layoutToggleIcon" style="font-size:18px; line-height:1;">dock_to_bottom</span>
</button>

"""
# Insertar justo antes del <aside
content = content.replace('<aside id="app-sidebar"', new_btn + '<aside id="app-sidebar"')

with open('app/views/partials/tailwind_sidebar.php', 'w') as f:
    f.write(content)

print('Toggle button fixed and placed at top-left corner.')
