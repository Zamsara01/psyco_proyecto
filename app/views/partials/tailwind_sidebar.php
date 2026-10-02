<?php
/**
 * Sidebar Unificado — 3 variantes según rol de usuario:
 *   - Invitado  : sin sesión
 *   - Paciente  : rol 'paciente'
 *   - Psicóloga : rol 'psicologo'
 */
$user    = $_SESSION['user'] ?? null;
$rol     = $user['rol'] ?? null;          // 'paciente' | 'psicologo' | null
$nombre  = $user['nombre']  ?? '';
$correo  = $user['correo']  ?? '';
$inicial = $nombre ? strtoupper(mb_substr($nombre, 0, 1)) : '?';

// URL actual para resaltar ítem activo
$urlActual = $_GET['url'] ?? '';
$isActive  = fn(string $path) => str_starts_with($urlActual, ltrim($path, '/'))
    ? 'text-[#3a6a8a] bg-[#dce8f0] font-semibold dark:bg-[#3A5C3D] dark:text-[#D7E6D5]'
    : 'text-slate-600 hover:text-[#4a6e8a] hover:bg-[#F4F7F6]/80 font-medium dark:text-[#8DA399] dark:hover:text-[#D7E6D5] dark:hover:bg-[#2C3634]';
?>

<aside id="app-sidebar" class="fixed inset-y-0 left-0 w-64 bg-white/70 dark:bg-[#2a2926] backdrop-blur-md border-r border-slate-200/50 dark:border-white/5 shadow-lg flex flex-col z-40 transition-transform duration-300 -translate-x-full lg:translate-x-0">

    <!-- ── Logo ─────────────────────────────────────────────── -->
    <div class="py-8 flex items-center justify-center border-b border-slate-100 dark:border-white/5 shrink-0 relative">
        <a href="<?= URL_BASE ?>" class="flex items-center justify-center w-full">
            <img alt="PSYCO Logo" class="w-44 h-auto object-contain drop-shadow-sm" src="<?= URL_BASE ?>public/img/psyco.png"/>
        </a>
        <!-- Botón cerrar sidebar (solo móvil) -->
        <button onclick="closeSidebar()" aria-label="Cerrar menú"
            class="lg:hidden absolute right-4 top-4 p-1.5 rounded-lg text-slate-400 hover:text-slate-600 hover:bg-slate-100 dark:hover:bg-white/10 dark:text-[#a39c8e] dark:hover:text-[#E4EAE6] transition-colors shrink-0">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>
    </div>

    <!-- ── Navegación ───────────────────────────────────────── -->
    <nav class="flex-grow py-5 px-3 flex flex-col overflow-hidden">
        <div class="space-y-1">
        <?php if ($rol === null): ?>
        <!-- ════════════ SIDEBAR INVITADO ════════════ -->

            <!-- Inicio -->
            <a href="<?= URL_BASE ?>"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">home</span>
                Inicio
            </a>

            <!-- Presentación -->
            <a href="<?= URL_BASE ?>pages/presentacion"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 dark:text-[#8DA399] hover:text-[#4a6e8a] dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634]">
                <span class="material-symbols-outlined text-[22px] shrink-0">folder_special</span>
                Presentación
            </a>

            <!-- Calendario — bloqueado -->
            <button onclick="openLoginRequiredModal('Calendario')"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-400 dark:text-[#8DA399] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634] relative">
                <span class="material-symbols-outlined text-[22px] shrink-0 text-slate-300 dark:text-slate-600 group-hover:text-slate-400 dark:group-hover:text-slate-500">calendar_month</span>
                Calendario
                <span class="ml-auto material-symbols-outlined text-[14px] text-slate-300 dark:text-slate-600 group-hover:text-slate-400">lock</span>
                
                <!-- Tooltip -->
                <div class="absolute left-full ml-3 top-1/2 -translate-y-1/2 w-max px-3 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none hidden md:block">
                    Inicia sesión para acceder
                    <div class="absolute right-full top-1/2 -translate-y-1/2 border-4 border-transparent border-r-slate-800"></div>
                </div>
            </button>

            <!-- Acceso Rápido — bloqueado -->
            <button onclick="openLoginRequiredModal('Acceso Rápido')"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-400 dark:text-[#8DA399] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634] relative">
                <span class="material-symbols-outlined text-[22px] shrink-0 text-slate-300 dark:text-slate-600 group-hover:text-slate-400">forum</span>
                Acceso Rápido
                <span class="ml-auto material-symbols-outlined text-[14px] text-slate-300 dark:text-slate-600 group-hover:text-slate-400">lock</span>
                
                <!-- Tooltip -->
                <div class="absolute left-full ml-3 top-1/2 -translate-y-1/2 w-max px-3 py-1.5 bg-slate-800 text-white text-xs font-medium rounded-lg opacity-0 invisible group-hover:opacity-100 group-hover:visible transition-all z-50 pointer-events-none hidden md:block">
                    Inicia sesión para acceder
                    <div class="absolute right-full top-1/2 -translate-y-1/2 border-4 border-transparent border-r-slate-800"></div>
                </div>
            </button>

        <?php elseif ($rol === 'paciente'): ?>
        <!-- ════════════ SIDEBAR PACIENTE ════════════ -->

            <!-- Inicio -->
            <a href="<?= URL_BASE ?>"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">home</span>
                Inicio
            </a>

            <!-- Calendario -->
            <a href="<?= URL_BASE ?>calendario"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('calendario') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">calendar_month</span>
                Calendario
            </a>

            <!-- Acceso Rápido -->
            <button onclick="openChatbotModal()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 dark:text-[#8DA399] hover:text-[#4a6e8a] dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634]">
                <span class="material-symbols-outlined text-[22px] shrink-0">forum</span>
                Acceso Rápido
            </button>

            <!-- Mis Recursos (Dropdown) -->
            <div x-data="{ open: false }" class="relative" id="misRecursosDropdown">
                <button onclick="toggleMisRecursos()"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md w-full text-left text-slate-600 hover:text-[#4a6e8a] hover:bg-[#F4F7F6] group"
                    aria-expanded="false" id="misRecursosBtn">
                    <span class="material-symbols-outlined text-[22px] shrink-0">folder_open</span>
                    <span class="flex-1">Citas y Recursos</span>
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-200" id="misRecursosChevron">expand_more</span>
                </button>

                <!-- Submenú -->
                <div id="misRecursosMenu" class="hidden pl-4 space-y-0.5 mt-0.5">
                    <a href="<?= URL_BASE ?>citas/misCitas"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all <?= $isActive('citas/misCitas') ? 'text-[#4a6e8a] dark:text-blue-400 bg-[#dce8f0] dark:bg-blue-900/30 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-[#4a6e8a] dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634]' ?>">
                        <span class="material-symbols-outlined text-[18px] shrink-0">event_note</span>
                        Mis Citas
                    </a>
                    <a href="<?= URL_BASE ?>citas/misRecursos"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all <?= $isActive('citas/misRecursos') ? 'text-[#4a6e8a] dark:text-blue-400 bg-[#dce8f0] dark:bg-blue-900/30 font-semibold' : 'text-slate-500 dark:text-slate-400 hover:text-[#4a6e8a] dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634]' ?>">
                        <span class="material-symbols-outlined text-[18px] shrink-0">library_books</span>
                        Recursos
                    </a>
                </div>
            </div>



        <?php elseif ($rol === 'psicologo'): ?>
        <!-- ════════════ SIDEBAR PSICÓLOGA ════════════ -->

            <!-- Inicio -->
            <a href="<?= URL_BASE ?>"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">home</span>
                Inicio
            </a>

            <!-- Calendario -->
            <a href="<?= URL_BASE ?>calendario"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('calendario') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">calendar_month</span>
                Calendario
            </a>

            <!-- Acceso Rápido -->
            <button onclick="openChatbotModal()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 dark:text-[#8DA399] hover:text-[#4a6e8a] dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634]">
                <span class="material-symbols-outlined text-[22px] shrink-0">forum</span>
                Acceso Rápido
            </button>

            <!-- Mi Panel -->
            <a href="<?= URL_BASE ?>panel_psicologas"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('panel_psicologas') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">dashboard</span>
                Mi Panel
            </a>

            <!-- Recursos -->
            <a href="<?= URL_BASE ?>panel_psicologas/recursos"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('panel_psicologas/recursos') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">folder_open</span>
                Recursos
            </a>

            <!-- Búsquedas Específicas -->
            <button onclick="openBusquedaModal()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 dark:text-[#8DA399] hover:text-[#4a6e8a] dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634]">
                <span class="material-symbols-outlined text-[22px] shrink-0">manage_search</span>
                Búsquedas Específicas
            </button>

            <!-- Reuniones -->
            <button onclick="openReunionesModal()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 dark:text-[#8DA399] hover:text-[#4a6e8a] dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634]">
                <span class="material-symbols-outlined text-[22px] shrink-0">groups</span>
                Reuniones
            </button>

            <!-- Historial Clínico -->
            <button onclick="openHistorialModal()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 dark:text-[#8DA399] hover:text-[#4a6e8a] dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6]/80 dark:hover:bg-[#2C3634]">
                <span class="material-symbols-outlined text-[22px] shrink-0">history_edu</span>
                Historial Clínico
            </button>

        <?php elseif ($rol === 'superusuario'): ?>
        <!-- ════════════ SIDEBAR SUPERUSUARIO ════════════ -->

            <!-- Usuarios -->
            <a href="<?= URL_BASE ?>superusuario/usuarios"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('superusuario/usuarios') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">group</span>
                Usuarios
            </a>

            <!-- Citas y Recursos -->
            <a href="<?= URL_BASE ?>superusuario/citasRecursos"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('superusuario/citasRecursos') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">event_note</span>
                Citas y Recursos
            </a>

            <!-- Códigos OTP -->
            <a href="<?= URL_BASE ?>superusuario/codigos"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('superusuario/codigos') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">pin</span>
                Códigos OTP
            </a>

            <!-- Auditoría -->
            <a href="<?= URL_BASE ?>superusuario/auditoria"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('superusuario/auditoria') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">security</span>
                Auditoría
            </a>

            <!-- Importaciones -->
            <a href="<?= URL_BASE ?>superusuario/importaciones"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('superusuario/importaciones') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">upload_file</span>
                Importaciones
            </a>

            <!-- Exportaciones -->
            <a href="<?= URL_BASE ?>superusuario/exportaciones"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('superusuario/exportaciones') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">download</span>
                Exportaciones
            </a>

        <?php endif; ?>
        </div>

    </nav>

    <!-- ── Footer de Usuario ─────────────────────────────────── -->
    <div class="border-t border-slate-100 dark:border-white/5 p-4 shrink-0">
        <?php if ($user): ?>
            <!-- Usuario logueado -->
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-blue-500 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                    <?= htmlspecialchars($inicial) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 dark:text-[#E4EAE6] truncate"><?= htmlspecialchars($nombre) ?></p>
                    <p class="text-xs text-slate-400 dark:text-[#8DA399] truncate">
                        <?= $rol === 'psicologo' ? '🧠 Psicóloga' : '👤 Paciente' ?>
                    </p>
                </div>
            </div>

            <!-- Toggle dark mode + Toggle layout (en fila) -->
            <div class="flex items-center gap-2 mb-2">
                <button onclick="toggleDarkMode()"
                    class="flex flex-1 items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-500 dark:text-[#a39c8e] hover:bg-slate-100 dark:hover:bg-white/5 dark:hover:text-[#E4EAE6] rounded-xl transition-colors">
                    <span class="material-symbols-outlined text-[18px]" id="darkModeIcon">dark_mode</span>
                    <span id="darkModeLabel">Modo oscuro</span>
                </button>
                <button onclick="toggleLayoutMode()" id="layoutToggleBtn"
                    aria-label="Alternar diseño" title="Cambiar entre Navbar y Sidebar"
                    class="flex items-center justify-center p-2 text-slate-500 dark:text-[#a39c8e] hover:text-blue-500 dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6] dark:hover:bg-white/5 rounded-xl transition-colors shrink-0 border border-slate-200 dark:border-white/5">
                    <span class="material-symbols-outlined text-[18px]" id="layoutToggleIcon">dock_to_bottom</span>
                </button>
            </div>

            <a href="<?= URL_BASE ?>users/logout"
               class="flex items-center justify-center gap-2 w-full px-4 py-2 text-sm font-semibold text-slate-600 dark:text-[#a39c8e] bg-slate-50 dark:bg-white/5 hover:bg-red-50 dark:hover:bg-red-900/30 hover:text-red-600 dark:hover:text-red-300 rounded-xl transition-colors border border-slate-200 dark:border-white/5">
                <span class="material-symbols-outlined text-[18px]">logout</span>
                Cerrar sesión
            </a>

        <?php else: ?>
            <!-- Invitado -->
            <div class="space-y-2">
                <!-- Toggle dark mode + Toggle layout (en fila) -->
                <div class="flex items-center gap-2">
                    <button onclick="toggleDarkMode()"
                        class="flex flex-1 items-center gap-2 px-4 py-2 text-sm font-semibold text-slate-500 dark:text-[#a39c8e] hover:bg-slate-100 dark:hover:bg-white/5 dark:hover:text-[#E4EAE6] rounded-xl transition-colors">
                        <span class="material-symbols-outlined text-[18px]" id="darkModeIcon">dark_mode</span>
                        <span id="darkModeLabel">Modo oscuro</span>
                    </button>
                    <button onclick="toggleLayoutMode()" id="layoutToggleBtn"
                        aria-label="Alternar diseño" title="Cambiar entre Navbar y Sidebar"
                        class="flex items-center justify-center p-2 text-slate-500 dark:text-[#a39c8e] hover:text-blue-500 dark:hover:text-[#D7E6D5] hover:bg-[#F4F7F6] dark:hover:bg-white/5 rounded-xl transition-colors shrink-0 border border-slate-200 dark:border-white/5">
                        <span class="material-symbols-outlined text-[18px]" id="layoutToggleIcon">dock_to_bottom</span>
                    </button>
                </div>
                <button onclick="openLoginModal()"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-white bg-[#6B8CAE] hover:bg-[#5a7e9f] rounded-xl transition-all active:scale-[0.98] shadow-sm shadow-slate-200">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Iniciar sesión
                </button>
                <button onclick="openRegisterModal()"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-[#4a6e8a] bg-white border-2 border-[#b5cfe0] hover:bg-[#F4F7F6] rounded-xl transition-all active:scale-[0.98]">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    Registrarse
                </button>
            </div>
        <?php endif; ?>
    </div>
</aside>

<!-- ══════════════ MODAL DE BÚSQUEDA (solo psicóloga) ══════════════ -->
<?php if ($rol === 'psicologo'): ?>
<div id="busquedaModal" class="fixed inset-0 z-[60] hidden items-end sm:items-center justify-center" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeBusquedaModal()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-t-3xl sm:rounded-3xl shadow-2xl w-full max-w-2xl mx-0 sm:mx-4 z-10 flex flex-col max-h-[85vh]">

        <!-- Header -->
        <div class="flex items-center gap-4 p-6 border-b border-slate-100 dark:border-slate-700">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-[#4a6e8a] dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">manage_search</span>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Búsqueda de Pacientes</h3>
                <p class="text-xs text-slate-500 dark:text-slate-400">Busca por nombre o correo electrónico</p>
            </div>
            <button onclick="closeBusquedaModal()" class="p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 hover:text-slate-600 dark:hover:text-slate-300 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Buscador -->
        <div class="p-5 border-b border-slate-50 dark:border-slate-700">
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-500 text-[20px]">search</span>
                    <input type="text" id="busquedaInput" placeholder="Nombre o correo del paciente..."
                        oninput="doBusqueda(this.value)"
                        class="w-full pl-10 pr-4 py-2.5 border-2 border-slate-200 dark:border-slate-600 rounded-xl bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
        </div>

        <!-- Resultados -->
        <div id="busquedaResultados" class="flex-1 overflow-y-auto p-5 space-y-3 min-h-[180px]">
            <div class="text-center py-10 text-slate-400 dark:text-[#8DA399]">
                <span class="material-symbols-outlined text-[48px] block mb-2 text-slate-200 dark:text-slate-600">person_search</span>
                <p class="text-sm">Escribe para buscar pacientes</p>
            </div>
        </div>
    </div>
</div>

<script>
// ── Búsqueda Modal ────────────────────────────────────────────────
function openBusquedaModal() {
    const m = document.getElementById('busquedaModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    setTimeout(() => document.getElementById('busquedaInput')?.focus(), 100);
}
function closeBusquedaModal() {
    document.getElementById('busquedaModal').classList.add('hidden');
    document.getElementById('busquedaModal').classList.remove('flex');
    document.body.style.overflow = '';
    document.getElementById('busquedaInput').value = '';
    document.getElementById('busquedaResultados').innerHTML = `
        <div class="text-center py-10 text-slate-400 dark:text-[#8DA399]">
            <span class="material-symbols-outlined text-[48px] block mb-2 text-slate-200 dark:text-slate-600">person_search</span>
            <p class="text-sm">Escribe para buscar pacientes</p>
        </div>`;
}

let busquedaTimer = null;
function doBusqueda(q) {
    clearTimeout(busquedaTimer);
    if (q.trim().length < 2) {
        document.getElementById('busquedaResultados').innerHTML = `
            <div class="text-center py-10 text-slate-400">
                <span class="material-symbols-outlined text-[48px] block mb-2 text-slate-200">person_search</span>
                <p class="text-sm">Escribe al menos 2 caracteres</p>
            </div>`;
        return;
    }
    busquedaTimer = setTimeout(async () => {
        const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
        document.getElementById('busquedaResultados').innerHTML = `<div class="flex justify-center py-10"><div class="w-8 h-8 border-4 border-blue-200 dark:border-blue-900 border-t-blue-500 rounded-full animate-spin"></div></div>`;
        try {
            const res = await fetch(BASE + 'panel_psicologas/buscarPaciente?q=' + encodeURIComponent(q));
            const data = await res.json();
            if (!data.ok || !data.pacientes.length) {
                document.getElementById('busquedaResultados').innerHTML = `<div class="text-center py-10 text-slate-400 dark:text-[#8DA399]"><span class="material-symbols-outlined text-[40px] block mb-2 text-slate-200 dark:text-slate-600">search_off</span><p class="text-sm">No se encontraron pacientes</p></div>`;
                return;
            }
            renderBusquedaResultados(data.pacientes);
        } catch(e) {
            document.getElementById('busquedaResultados').innerHTML = `<p class="text-red-500 dark:text-red-400 text-sm text-center py-6">Error al buscar: ${e.message}</p>`;
        }
    }, 350);
}

function renderBusquedaResultados(pacientes) {
    const el = document.getElementById('busquedaResultados');
    el.innerHTML = pacientes.map(p => `
        <div class="flex items-center gap-4 p-4 bg-white dark:bg-slate-700/50 border-2 border-slate-100 dark:border-slate-700 rounded-2xl hover:border-blue-200 dark:hover:border-blue-700 hover:bg-[#F4F7F6]/20 dark:hover:bg-slate-700 transition-all cursor-pointer group"
             onclick="verHistorial(${p.id_usuario}, '${escBusqueda(p.nombre)}')">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-emerald-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                ${escBusqueda(p.nombre.charAt(0).toUpperCase())}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-slate-800 dark:text-slate-100 truncate">${escBusqueda(p.nombre)}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">${escBusqueda(p.correo_electronico)} · Grado ${escBusqueda(p.grado || '?')}</p>
            </div>
            <div class="text-right shrink-0">
                <p class="text-xs font-bold text-[#4a6e8a] dark:text-blue-400">${p.total_citas} cita${p.total_citas != 1 ? 's' : ''}</p>
                <p class="text-[10px] text-slate-400 dark:text-[#8DA399]">${p.ultima_cita || ''}</p>
            </div>
            <span class="material-symbols-outlined text-slate-300 dark:text-slate-500 group-hover:text-blue-400 dark:group-hover:text-blue-400 transition-colors">chevron_right</span>
        </div>
    `).join('');
}

async function verHistorial(idUsuario, nombre) {
    const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
    document.getElementById('busquedaResultados').innerHTML = `<div class="flex justify-center py-10"><div class="w-8 h-8 border-4 border-blue-200 border-t-blue-500 rounded-full animate-spin"></div></div>`;
    try {
        const res = await fetch(BASE + 'panel_psicologas/historialPaciente?id_usuario=' + idUsuario);
        const data = await res.json();
        if (!data.ok) throw new Error(data.error);
        renderHistorial(nombre, data.historial, idUsuario);
    } catch(e) {
        document.getElementById('busquedaResultados').innerHTML = `<p class="text-red-500 text-sm text-center py-6">Error: ${e.message}</p>`;
    }
}

function renderHistorial(nombre, historial, idUsuario) {
    const estadoColor = {
        pendiente:'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-400',
        completada:'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400',
        cancelada:'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-400',
        'en proceso':'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-400'
    };
    const el = document.getElementById('busquedaResultados');
    el.innerHTML = `
        <button onclick="doBusqueda(document.getElementById('busquedaInput').value)" class="flex items-center gap-2 text-sm text-slate-500 dark:text-slate-400 hover:text-blue-500 dark:hover:text-[#D7E6D5] mb-4 transition-colors">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span> Volver
        </button>
        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100 dark:border-slate-700">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-blue-500 to-emerald-600 flex items-center justify-center text-white font-bold">${escBusqueda(nombre.charAt(0).toUpperCase())}</div>
            <div>
                <p class="font-bold text-slate-800 dark:text-slate-100">${escBusqueda(nombre)}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400">${historial.length} cita${historial.length != 1 ? 's' : ''} registrada${historial.length != 1 ? 's' : ''}</p>
            </div>
        </div>
        ${historial.length === 0 ? `<p class="text-center text-slate-400 dark:text-[#8DA399] text-sm py-4">Sin citas registradas.</p>` :
        historial.map(c => `
            <div class="p-4 bg-slate-50 dark:bg-slate-700/50 rounded-xl border border-slate-100 dark:border-slate-700 space-y-1 mb-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-slate-700 dark:text-slate-200">${c.fecha} · ${c.hora.slice(0,5)}</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full ${estadoColor[c.estado] || 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400'}">${c.estado}</span>
                </div>
                ${c.motivo_consulta ? `<p class="text-xs text-slate-500 dark:text-slate-400">Motivo: ${escBusqueda(c.motivo_consulta)}</p>` : ''}
                ${c.notas_sesion ? `<p class="text-xs text-slate-400 dark:text-[#8DA399] italic">Notas: ${escBusqueda(c.notas_sesion)}</p>` : ''}
            </div>
        `).join('')}
    `;
}

function escBusqueda(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>
<?php endif; ?>

<script>
// ── Mis Recursos Dropdown ─────────────────────────────────────────
function toggleMisRecursos() {
    const menu    = document.getElementById('misRecursosMenu');
    const chevron = document.getElementById('misRecursosChevron');
    const btn     = document.getElementById('misRecursosBtn');
    if (!menu) return;
    const isOpen = !menu.classList.contains('hidden');
    menu.classList.toggle('hidden', isOpen);
    if (chevron) chevron.style.transform = isOpen ? '' : 'rotate(180deg)';
    btn?.setAttribute('aria-expanded', String(!isOpen));
}

(function() {
    const url = window.location.href;
    if (url.includes('citas/misCitas') || url.includes('citas/misRecursos')) {
        const menu    = document.getElementById('misRecursosMenu');
        const chevron = document.getElementById('misRecursosChevron');
        if (menu) { menu.classList.remove('hidden'); }
        if (chevron) chevron.style.transform = 'rotate(180deg)';
    }
})();

</script>

<!-- ══════════════ MODAL DE REUNIONES (solo psicóloga) ══════════════ -->
<?php if ($rol === 'psicologo'): ?>
<div id="reunionesModal" class="fixed inset-0 z-[60] hidden items-end sm:items-center justify-center" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeReunionesModal()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-t-3xl sm:rounded-3xl shadow-2xl w-full max-w-md mx-0 sm:mx-4 z-10 flex flex-col p-6 text-center">
        <!-- Header -->
        <div class="flex justify-between items-center mb-4">
            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-xl flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-500">groups</span> Reuniones
            </h3>
            <button onclick="closeReunionesModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <div id="reunionesContenido" class="flex flex-col items-center justify-center min-h-[200px]">
            <div class="w-8 h-8 border-4 border-blue-200 border-t-blue-500 rounded-full animate-spin"></div>
        </div>
    </div>
</div>

<script>
let reunionesInterval = null;
let currentCitaData   = null;
// Offset en segundos desde el origen que nos dio el servidor
let reunionesOffsetSecs = 0;
let reunionesLoadedAt   = 0; // Date.now() en el momento en que se fijó el offset

function openReunionesModal() {
    const m = document.getElementById('reunionesModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    cargarCitaMasProxima();
}

function closeReunionesModal() {
    document.getElementById('reunionesModal').classList.add('hidden');
    document.getElementById('reunionesModal').classList.remove('flex');
    document.body.style.overflow = '';
    if (reunionesInterval) clearInterval(reunionesInterval);
    reunionesInterval = null;
}

async function cargarCitaMasProxima() {
    if (reunionesInterval) { clearInterval(reunionesInterval); reunionesInterval = null; }
    document.getElementById('reunionesContenido').innerHTML =
        '<div class="w-8 h-8 border-4 border-blue-200 border-t-blue-500 rounded-full animate-spin mx-auto my-10"></div>';

    const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
    try {
        const res  = await fetch(BASE + 'panel_psicologas/citaMasProxima');
        const data = await res.json();

        if (!data.ok || !data.cita) {
            document.getElementById('reunionesContenido').innerHTML = `
                <span class="material-symbols-outlined text-[48px] text-slate-300 dark:text-slate-600 mb-2 block">event_busy</span>
                <p class="text-slate-500 dark:text-slate-400 font-medium">No hay reuniones programadas para hoy.</p>
            `;
            return;
        }

        currentCitaData   = data;
        reunionesLoadedAt = Date.now();

        if (data.estado === 'pendiente') {
            // minutos_transcurridos: positivo = ya pasó, negativo = falta tiempo
            reunionesOffsetSecs = parseFloat(data.cita.minutos_transcurridos || 0) * 60;
        } else {
            // en_proceso: el servidor nos da minutos_en_curso (calculado con MySQL NOW())
            reunionesOffsetSecs = parseFloat(data.cita.minutos_en_curso || 1) * 60;
        }

        iniciarLogicaReunion();
    } catch(e) {
        document.getElementById('reunionesContenido').innerHTML =
            `<p class="text-red-500 text-sm py-8">Error al cargar: ${e.message}</p>`;
    }
}

function iniciarLogicaReunion() {
    actualizarVistaReunion();
    if (reunionesInterval) clearInterval(reunionesInterval);
    reunionesInterval = setInterval(actualizarVistaReunion, 1000);
}

function actualizarVistaReunion() {
    const cita   = currentCitaData.cita;
    const estado = currentCitaData.estado;

    // Segundos reales que han pasado desde que fijamos el offset
    const segsDesdeLoad   = (Date.now() - reunionesLoadedAt) / 1000;
    const segsTotal       = reunionesOffsetSecs + segsDesdeLoad;
    const minutosTotal    = Math.floor(segsTotal / 60);

    let html = `
        <div class="w-16 h-16 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center mb-4 mx-auto">
            <span class="material-symbols-outlined text-[#4a6e8a] dark:text-blue-400 text-3xl">person</span>
        </div>
        <h4 class="text-lg font-bold text-slate-800 dark:text-slate-100 mb-1">${escReunion(cita.paciente_nombre)}</h4>
        <p class="text-sm text-slate-500 dark:text-slate-400 mb-5">
            <span class="material-symbols-outlined text-[14px] align-middle">schedule</span> ${cita.hora.slice(0,5)}
        </p>
    `;

    if (estado === 'pendiente') {
        if (segsTotal < 0) {
            // Cita aún no empieza — cuenta regresiva
            const totalRest = Math.abs(segsTotal);
            const mRest = Math.floor(totalRest / 60);
            const sRest = Math.floor(totalRest % 60);
            html += `
                <div class="bg-blue-50 dark:bg-blue-900/20 border border-blue-200 dark:border-blue-700/50 rounded-xl p-5 w-full text-center">
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-1 font-medium">La cita inicia en:</p>
                    <p class="text-3xl font-bold text-[#4a6e8a] dark:text-blue-400 tabular-nums">
                        ${mRest}m ${String(sRest).padStart(2,'0')}s
                    </p>
                </div>
            `;
        } else if (minutosTotal <= 10) {
            // Primeros 10 minutos — botones de asistencia
            const restantes = 10 - minutosTotal;
            html += `
                <div class="bg-yellow-50 dark:bg-yellow-900/20 border border-yellow-200 dark:border-yellow-700/50 rounded-xl p-5 w-full">
                    <div class="flex items-center justify-center gap-2 mb-2">
                        <span class="material-symbols-outlined text-yellow-600 text-[20px]">notifications_active</span>
                        <p class="text-sm font-semibold text-yellow-700 dark:text-yellow-400">¡La cita ha iniciado!</p>
                    </div>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">¿El paciente asistió a la sesión?</p>
                    <div class="flex gap-3 justify-center">
                        <button onclick="marcarNoAsistio(${cita.id_cita})"
                            class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 bg-red-100 text-red-700 hover:bg-red-200 dark:bg-red-900/30 dark:text-red-400 dark:hover:bg-red-900/50 rounded-xl text-sm font-semibold transition-colors">
                            <span class="material-symbols-outlined text-[18px]">person_off</span>
                            No asistió
                        </button>
                        <button onclick="marcarSiAsistio(${cita.id_cita})"
                            class="flex-1 flex items-center justify-center gap-1.5 px-3 py-2.5 bg-green-100 text-green-700 hover:bg-green-200 dark:bg-green-900/30 dark:text-green-400 dark:hover:bg-green-900/50 rounded-xl text-sm font-semibold transition-colors">
                            <span class="material-symbols-outlined text-[18px]">how_to_reg</span>
                            Sí asistió
                        </button>
                    </div>
                    <p class="text-[10px] text-slate-400 dark:text-[#8DA399] mt-3">
                        ${restantes} min restante${restantes !== 1 ? 's' : ''} para confirmar asistencia
                    </p>
                </div>
            `;
        } else {
            // Pasaron los 10 minutos sin confirmar
            html += `
                <div class="bg-red-50 dark:bg-red-900/20 border border-red-200 dark:border-red-700/50 rounded-xl p-5 w-full text-center">
                    <span class="material-symbols-outlined text-red-400 text-[32px] block mb-2">timer_off</span>
                    <p class="text-sm font-semibold text-red-700 dark:text-red-400 mb-3">Ventana de asistencia expirada</p>
                    <p class="text-xs text-slate-500 dark:text-slate-400 mb-4">Han pasado más de 10 minutos sin confirmar.</p>
                    <button onclick="marcarNoAsistio(${cita.id_cita})"
                        class="w-full px-4 py-2.5 bg-red-100 text-red-700 hover:bg-red-200 rounded-xl text-sm font-semibold transition-colors">
                        Marcar como No asistió
                    </button>
                </div>
            `;
        }

    } else if (estado === 'en_proceso') {
        // segsTotal ya parte de minutos_en_curso del servidor → siempre preciso
        const mins = Math.max(1, minutosTotal);
        const segsRestantes = Math.floor(segsTotal % 60);

        html += `
            <div class="bg-green-50 dark:bg-green-900/20 border border-green-200 dark:border-green-700/50 rounded-xl p-5 w-full text-center">
                <div class="flex items-center justify-center gap-2 mb-2">
                    <span class="material-symbols-outlined text-green-600 text-[20px]">play_circle</span>
                    <p class="text-sm font-semibold text-green-700 dark:text-green-400">Cita en curso</p>
                </div>
                <p class="text-3xl font-bold text-green-600 dark:text-green-400 mb-1 tabular-nums">${mins} min</p>
                <p class="text-xs text-slate-400 mb-5 tabular-nums">${String(Math.floor(segsTotal / 60)).padStart(2,'0')}:${String(segsRestantes).padStart(2,'0')}</p>
                <button onclick="finalizarReunion(${cita.id_cita}, ${mins})"
                    class="w-full flex items-center justify-center gap-2 px-4 py-3 bg-blue-600 text-white hover:bg-blue-700 rounded-xl text-sm font-bold shadow transition-colors">
                    <span class="material-symbols-outlined text-[20px]">stop_circle</span>
                    Finalizar Cita
                </button>
            </div>
        `;
    }

    document.getElementById('reunionesContenido').innerHTML = html;
}

async function marcarNoAsistio(idCita) {
    if (!confirm('¿Seguro que deseas marcar como "No asistió"?')) return;
    const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
    try {
        const res  = await fetch(BASE + 'panel_psicologas/citaNoAsistio', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id_cita: idCita})
        });
        const data = await res.json();
        if (data.ok) { cargarCitaMasProxima(); }
        else { alert('Error: ' + (data.error || 'No se pudo registrar.')); }
    } catch(e) { alert('Error de red: ' + e.message); }
}

async function marcarSiAsistio(idCita) {
    const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
    try {
        const res  = await fetch(BASE + 'panel_psicologas/citaSiAsistio', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id_cita: idCita})
        });
        const data = await res.json();
        if (data.ok) {
            // Cambiar a en_proceso y fijar offset desde 0 (acaba de iniciar)
            currentCitaData.estado              = 'en_proceso';
            currentCitaData.cita.minutos_en_curso = 0;
            reunionesOffsetSecs                 = 0;
            reunionesLoadedAt                   = Date.now();
            actualizarVistaReunion();
        } else { alert('Error: ' + (data.error || 'No se pudo registrar.')); }
    } catch(e) { alert('Error de red: ' + e.message); }
}

async function finalizarReunion(idCita, duracion) {
    if (duracion < 1) duracion = 1;
    if (!confirm(`¿Finalizar la cita? Duración registrada: ${duracion} minuto${duracion !== 1 ? 's' : ''}.`)) return;
    const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
    try {
        const res  = await fetch(BASE + 'panel_psicologas/finalizarReunion', {
            method: 'POST', headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({id_cita: idCita, duracion: duracion})
        });
        const data = await res.json();
        if (data.ok) {
            if (reunionesInterval) { clearInterval(reunionesInterval); reunionesInterval = null; }
            document.getElementById('reunionesContenido').innerHTML = `
                <span class="material-symbols-outlined text-[48px] text-green-400 mb-3 block">check_circle</span>
                <p class="text-slate-700 dark:text-slate-200 font-semibold mb-1">¡Cita finalizada!</p>
                <p class="text-xs text-slate-400">Duración: ${duracion} min. Datos guardados correctamente.</p>
            `;
            setTimeout(cargarCitaMasProxima, 3000);
        } else { alert('Error: ' + (data.error || 'No se pudo finalizar.')); }
    } catch(e) { alert('Error de red: ' + e.message); }
}

function escReunion(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}
</script>

<!-- ══════════ MODAL: HISTORIAL CLÍNICO ══════════ -->
<div id="historialModal" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeHistorialModal()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-lg mx-4 z-10 overflow-hidden flex flex-col max-h-[80vh]">
        <div class="p-6 pb-4 border-b border-slate-100 dark:border-slate-700/60 flex items-center justify-between shrink-0">
            <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-500">history_edu</span>
                Exportar Historial Clínico
            </h3>
            <button onclick="closeHistorialModal()" class="text-slate-400 hover:text-slate-600 dark:hover:text-slate-300">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>
        <div class="p-6 overflow-y-auto" id="historialContenido">
            <div class="w-8 h-8 border-4 border-blue-200 border-t-blue-500 rounded-full animate-spin mx-auto my-6"></div>
        </div>
    </div>
</div>

<script>
function openHistorialModal() {
    const m = document.getElementById('historialModal');
    m.classList.remove('hidden'); m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    cargarPacientesHistorial();
}

function closeHistorialModal() {
    const m = document.getElementById('historialModal');
    m.classList.add('hidden'); m.classList.remove('flex');
    document.body.style.overflow = '';
}

async function cargarPacientesHistorial() {
    const cont = document.getElementById('historialContenido');
    cont.innerHTML = '<div class="w-8 h-8 border-4 border-blue-200 border-t-blue-500 rounded-full animate-spin mx-auto my-6"></div>';
    
    const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
    try {
        const res = await fetch(BASE + 'panel_psicologas/pacientesConNotas');
        const data = await res.json();
        
        if (!data.ok || !data.pacientes || data.pacientes.length === 0) {
            cont.innerHTML = `
                <div class="text-center py-6">
                    <span class="material-symbols-outlined text-[48px] text-slate-300 dark:text-slate-600 mb-2 block">folder_off</span>
                    <p class="text-slate-500 dark:text-slate-400 font-medium">No has registrado notas para ningún paciente aún.</p>
                </div>
            `;
            return;
        }

        let html = '<p class="text-sm text-slate-500 dark:text-slate-400 mb-4">Selecciona un paciente para descargar e imprimir su historial clínico basado en tus notas:</p>';
        html += '<div class="space-y-2">';
        
        data.pacientes.forEach(p => {
            html += `
                <div class="flex items-center justify-between p-3 bg-slate-50 dark:bg-slate-800/50 border border-slate-100 dark:border-slate-700/50 rounded-xl hover:border-blue-200 dark:hover:border-blue-900/50 transition-colors">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 bg-blue-100 dark:bg-blue-900/40 text-[#4a6e8a] dark:text-blue-400 rounded-full flex items-center justify-center font-bold text-sm">
                            ${escReunion(p.paciente_nombre).charAt(0).toUpperCase()}
                        </div>
                        <p class="font-semibold text-slate-700 dark:text-slate-200 text-sm">${escReunion(p.paciente_nombre)}</p>
                    </div>
                    <a href="${BASE}panel_psicologas/imprimirHistorial?id_usuario=${p.id_usuario}" target="_blank"
                       class="px-3 py-1.5 bg-blue-600 text-white text-xs font-bold rounded-lg hover:bg-blue-700 transition-colors flex items-center gap-1 shadow-sm">
                       <span class="material-symbols-outlined text-[16px]">print</span>
                       Generar
                    </a>
                </div>
            `;
        });
        html += '</div>';
        cont.innerHTML = html;
        
    } catch (e) {
        cont.innerHTML = `<p class="text-red-500 text-sm py-4 text-center">Error: ${e.message}</p>`;
    }
}
</script>
<?php endif; ?>




<!-- ══════════════ SCRIPT Y ESTILOS PARA NAVBAR MODE ══════════════ -->
<style>
/* ---------- NAVBAR MODE STYLES ---------- */
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
    border-bottom: 1px solid rgba(148,163,184,0.15) !important;
    padding: 0 1.25rem !important;
    gap: 0 !important;
    transform: none !important;
    overflow: visible !important;
}

/* Dark mode: borde inferior más sutil y fondo opaco */
.dark body.navbar-mode #app-sidebar {
    border-bottom: 1px solid rgba(255,255,255,0.05) !important;
    background-color: #2a2926 !important;
    background-image: none !important;
}

/* Cabecera (logo) — ancho fijo, sin borde inferior */
body.navbar-mode #app-sidebar > div:first-child {
    border-bottom: none !important;
    height: 60px !important;
    min-width: max-content !important;
    padding: 0 1rem 0 0 !important;
    margin: 0 !important;
    flex-shrink: 0 !important;
    overflow: hidden !important;
    display: flex !important;
    align-items: center !important;
}

/* Logo: limitar tamaño dentro del navbar */
body.navbar-mode #app-sidebar > div:first-child img {
    height: 36px !important;
    width: auto !important;
    max-width: none !important;
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
.dark body.navbar-mode #misRecursosMenu { background: #2a2926 !important; border: 1px solid rgba(255,255,255,0.06) !important; box-shadow: 0 8px 24px rgba(0,0,0,0.4) !important; }
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
}

/* Transición suave del sidebar y main-content */
#app-sidebar {
    transition: width 0.4s cubic-bezier(0.4,0,0.2,1),
                transform 0.4s cubic-bezier(0.4,0,0.2,1),
                height 0.4s cubic-bezier(0.4,0,0.2,1),
                background-color 0.3s ease;
}
#main-content {
    transition: margin-left 0.4s cubic-bezier(0.4,0,0.2,1),
                padding-top 0.4s cubic-bezier(0.4,0,0.2,1),
                width 0.4s cubic-bezier(0.4,0,0.2,1);
}

/* Overlay de transición (flash suave) */
#layout-transition-overlay {
    pointer-events: none;
    position: fixed;
    inset: 0;
    z-index: 9999;
    background: transparent;
    opacity: 0;
    transition: opacity 0.18s ease;
}
#layout-transition-overlay.active {
    opacity: 1;
    background: rgba(0,0,0,0.18);
}
</style>

<!-- Overlay de transición de layout -->
<div id="layout-transition-overlay"></div>

<script>
function toggleLayoutMode() {
    const overlay = document.getElementById('layout-transition-overlay');
    const isNavbar = document.body.classList.contains('navbar-mode');

    // 1. Fade-in del overlay
    overlay.classList.add('active');

    setTimeout(() => {
        // 2. Aplicar el cambio de modo cuando el overlay cubre la pantalla
        if (isNavbar) {
            document.body.classList.remove('navbar-mode');
            localStorage.setItem('psyco-layout', 'sidebar');
            document.querySelectorAll('#layoutToggleIcon').forEach(el => el.textContent = 'dock_to_bottom');
        } else {
            document.body.classList.add('navbar-mode');
            localStorage.setItem('psyco-layout', 'navbar');
            document.querySelectorAll('#layoutToggleIcon').forEach(el => el.textContent = 'dock_to_left');
        }

        // 3. Fade-out del overlay
        setTimeout(() => {
            overlay.classList.remove('active');
        }, 80);

    }, 180);
}

document.addEventListener('DOMContentLoaded', () => {
    if (localStorage.getItem('psyco-layout') === 'navbar') {
        document.body.classList.add('navbar-mode');
        const icons = document.querySelectorAll('#layoutToggleIcon');
        icons.forEach(icon => icon.textContent = 'dock_to_left');
    }
});
</script>
