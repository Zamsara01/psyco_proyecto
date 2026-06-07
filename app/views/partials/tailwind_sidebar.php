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
    ? 'text-orange-600 bg-orange-50 font-semibold'
    : 'text-slate-600 hover:text-orange-600 hover:bg-orange-50/60 font-medium';
?>

<aside class="fixed inset-y-0 left-0 w-64 bg-white border-r border-slate-100 shadow-sm flex flex-col z-40 transition-transform duration-300">

    <!-- ── Logo ─────────────────────────────────────────────── -->
    <div class="h-16 flex items-center px-6 border-b border-slate-100 shrink-0">
        <a href="<?= URL_BASE ?>" class="flex items-center gap-3">
            <img alt="PSYCO Logo" class="h-8 w-auto object-contain" src="<?= URL_BASE ?>public/img/psyco.png"/>
            <span class="text-xl font-bold text-orange-600 hover:text-orange-700 transition-colors">PSYCO</span>
        </a>
    </div>

    <!-- ── Navegación ───────────────────────────────────────── -->
    <nav class="flex-grow py-5 px-3 space-y-1 overflow-y-auto">

        <?php if ($rol === null): ?>
        <!-- ════════════ SIDEBAR INVITADO ════════════ -->

            <!-- Inicio -->
            <a href="<?= URL_BASE ?>"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">home</span>
                Inicio
            </a>

            <!-- Calendario — bloqueado -->
            <button onclick="openLoginRequiredModal('Calendario')"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-400 hover:bg-slate-50 relative">
                <span class="material-symbols-outlined text-[22px] shrink-0 text-slate-300">calendar_month</span>
                Calendario
                <span class="ml-auto material-symbols-outlined text-[14px] text-slate-300">lock</span>
            </button>

            <!-- Chatbot — bloqueado -->
            <button onclick="openLoginRequiredModal('Chatbot de Citas')"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-400 hover:bg-slate-50">
                <span class="material-symbols-outlined text-[22px] shrink-0 text-slate-300">forum</span>
                Chatbot
                <span class="ml-auto material-symbols-outlined text-[14px] text-slate-300">lock</span>
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

            <!-- Chatbot -->
            <button onclick="openChatbotModal()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 hover:text-orange-600 hover:bg-orange-50/60">
                <span class="material-symbols-outlined text-[22px] shrink-0">forum</span>
                Chatbot
            </button>

            <!-- Mis Recursos (Dropdown) -->
            <div x-data="{ open: false }" class="relative" id="misRecursosDropdown">
                <button onclick="toggleMisRecursos()"
                    class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md w-full text-left text-slate-600 hover:text-orange-600 hover:bg-orange-50/60 group"
                    aria-expanded="false" id="misRecursosBtn">
                    <span class="material-symbols-outlined text-[22px] shrink-0">folder_open</span>
                    <span class="flex-1">Citas y Recursos</span>
                    <span class="material-symbols-outlined text-[18px] transition-transform duration-200" id="misRecursosChevron">expand_more</span>
                </button>

                <!-- Submenú -->
                <div id="misRecursosMenu" class="hidden pl-4 space-y-0.5 mt-0.5">
                    <a href="<?= URL_BASE ?>citas/misCitas"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all <?= $isActive('citas/misCitas') ? 'text-orange-600 bg-orange-50 font-semibold' : 'text-slate-500 hover:text-orange-600 hover:bg-orange-50/60' ?>">
                        <span class="material-symbols-outlined text-[18px] shrink-0">event_note</span>
                        Mis Citas
                    </a>
                    <a href="<?= URL_BASE ?>citas/misRecursos"
                       class="flex items-center gap-3 px-3 py-2 rounded-xl text-sm transition-all <?= $isActive('citas/misRecursos') ? 'text-orange-600 bg-orange-50 font-semibold' : 'text-slate-500 hover:text-orange-600 hover:bg-orange-50/60' ?>">
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

            <!-- Chatbot -->
            <button onclick="openChatbotModal()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 hover:text-orange-600 hover:bg-orange-50/60">
                <span class="material-symbols-outlined text-[22px] shrink-0">forum</span>
                Chatbot
            </button>

            <!-- Mi Panel -->
            <a href="<?= URL_BASE ?>panel_psicologas"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group <?= $isActive('panel_psicologas') ?>">
                <span class="material-symbols-outlined text-[22px] shrink-0">dashboard</span>
                Mi Panel
            </a>

            <!-- Búsquedas Específicas -->
            <button onclick="openBusquedaModal()"
               class="flex items-center gap-3 px-3 py-2.5 rounded-xl transition-all text-body-md group w-full text-left text-slate-600 hover:text-orange-600 hover:bg-orange-50/60">
                <span class="material-symbols-outlined text-[22px] shrink-0">manage_search</span>
                Búsquedas Específicas
            </button>

        <?php endif; ?>
    </nav>

    <!-- ── Footer de Usuario ─────────────────────────────────── -->
    <div class="border-t border-slate-100 p-4 shrink-0">
        <?php if ($user): ?>
            <!-- Usuario logueado -->
            <div class="flex items-center gap-3 px-2 mb-3">
                <div class="w-9 h-9 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm shrink-0 shadow-sm">
                    <?= htmlspecialchars($inicial) ?>
                </div>
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-semibold text-slate-800 truncate"><?= htmlspecialchars($nombre) ?></p>
                    <p class="text-xs text-slate-400 truncate">
                        <?= $rol === 'psicologo' ? '🧠 Psicóloga' : '👤 Paciente' ?>
                    </p>
                </div>
            </div>
            <a href="<?= URL_BASE ?>users/logout"
               class="flex items-center justify-center gap-2 w-full px-4 py-2 text-sm font-semibold text-slate-600 bg-slate-50 hover:bg-red-50 hover:text-red-600 rounded-xl transition-colors border border-slate-200">
                <span class="material-symbols-outlined text-[18px]">logout</span>
                Cerrar sesión
            </a>

        <?php else: ?>
            <!-- Invitado -->
            <div class="space-y-2">
                <button onclick="openLoginModal()"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-white bg-gradient-to-r from-orange-500 to-orange-600 hover:from-orange-600 hover:to-orange-700 rounded-xl transition-all active:scale-[0.98] shadow-sm shadow-orange-200">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Iniciar sesión
                </button>
                <button onclick="openRegisterModal()"
                    class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-orange-600 bg-white border-2 border-orange-200 hover:bg-orange-50 rounded-xl transition-all active:scale-[0.98]">
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
    <div class="relative bg-white rounded-t-3xl sm:rounded-3xl shadow-2xl w-full max-w-2xl mx-0 sm:mx-4 z-10 flex flex-col max-h-[85vh]">

        <!-- Header -->
        <div class="flex items-center gap-4 p-6 border-b border-slate-100">
            <div class="w-10 h-10 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined">manage_search</span>
            </div>
            <div class="flex-1">
                <h3 class="font-bold text-slate-800 text-lg">Búsqueda de Pacientes</h3>
                <p class="text-xs text-slate-500">Busca por nombre o correo electrónico</p>
            </div>
            <button onclick="closeBusquedaModal()" class="p-2 rounded-full hover:bg-slate-100 text-slate-400 hover:text-slate-600 transition-colors">
                <span class="material-symbols-outlined">close</span>
            </button>
        </div>

        <!-- Buscador -->
        <div class="p-5 border-b border-slate-50">
            <div class="flex gap-2">
                <div class="flex-1 relative">
                    <span class="material-symbols-outlined absolute left-3.5 top-1/2 -translate-y-1/2 text-slate-300 text-[20px]">search</span>
                    <input type="text" id="busquedaInput" placeholder="Nombre o correo del paciente..."
                        oninput="doBusqueda(this.value)"
                        class="w-full pl-10 pr-4 py-2.5 border-2 border-slate-200 rounded-xl text-slate-700 text-sm focus:outline-none focus:border-orange-400 transition-colors">
                </div>
            </div>
        </div>

        <!-- Resultados -->
        <div id="busquedaResultados" class="flex-1 overflow-y-auto p-5 space-y-3 min-h-[180px]">
            <div class="text-center py-10 text-slate-400">
                <span class="material-symbols-outlined text-[48px] block mb-2 text-slate-200">person_search</span>
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
        <div class="text-center py-10 text-slate-400">
            <span class="material-symbols-outlined text-[48px] block mb-2 text-slate-200">person_search</span>
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
        document.getElementById('busquedaResultados').innerHTML = `<div class="flex justify-center py-10"><div class="w-8 h-8 border-4 border-orange-200 border-t-orange-500 rounded-full animate-spin"></div></div>`;
        try {
            const res = await fetch(BASE + 'panel_psicologas/buscarPaciente?q=' + encodeURIComponent(q));
            const data = await res.json();
            if (!data.ok || !data.pacientes.length) {
                document.getElementById('busquedaResultados').innerHTML = `<div class="text-center py-10 text-slate-400"><span class="material-symbols-outlined text-[40px] block mb-2 text-slate-200">search_off</span><p class="text-sm">No se encontraron pacientes</p></div>`;
                return;
            }
            renderBusquedaResultados(data.pacientes);
        } catch(e) {
            document.getElementById('busquedaResultados').innerHTML = `<p class="text-red-500 text-sm text-center py-6">Error al buscar: ${e.message}</p>`;
        }
    }, 350);
}

function renderBusquedaResultados(pacientes) {
    const el = document.getElementById('busquedaResultados');
    el.innerHTML = pacientes.map(p => `
        <div class="flex items-center gap-4 p-4 bg-white border-2 border-slate-100 rounded-2xl hover:border-orange-200 hover:bg-orange-50/20 transition-all cursor-pointer group"
             onclick="verHistorial(${p.id_usuario}, '${escBusqueda(p.nombre)}')">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold text-sm shrink-0">
                ${escBusqueda(p.nombre.charAt(0).toUpperCase())}
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-slate-800 truncate">${escBusqueda(p.nombre)}</p>
                <p class="text-xs text-slate-500 truncate">${escBusqueda(p.correo_electronico)} · Grado ${escBusqueda(p.grado || '?')}</p>
            </div>
            <div class="text-right shrink-0">
                <p class="text-xs font-bold text-orange-600">${p.total_citas} cita${p.total_citas != 1 ? 's' : ''}</p>
                <p class="text-[10px] text-slate-400">${p.ultima_cita || ''}</p>
            </div>
            <span class="material-symbols-outlined text-slate-300 group-hover:text-orange-400 transition-colors">chevron_right</span>
        </div>
    `).join('');
}

async function verHistorial(idUsuario, nombre) {
    const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
    document.getElementById('busquedaResultados').innerHTML = `<div class="flex justify-center py-10"><div class="w-8 h-8 border-4 border-orange-200 border-t-orange-500 rounded-full animate-spin"></div></div>`;
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
    const estadoColor = {pendiente:'bg-blue-100 text-blue-700', completada:'bg-green-100 text-green-700', cancelada:'bg-red-100 text-red-700','en proceso':'bg-yellow-100 text-yellow-700'};
    const el = document.getElementById('busquedaResultados');
    el.innerHTML = `
        <button onclick="doBusqueda(document.getElementById('busquedaInput').value)" class="flex items-center gap-2 text-sm text-slate-500 hover:text-orange-500 mb-4 transition-colors">
            <span class="material-symbols-outlined text-[16px]">arrow_back</span> Volver
        </button>
        <div class="flex items-center gap-3 mb-4 pb-4 border-b border-slate-100">
            <div class="w-10 h-10 rounded-full bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center text-white font-bold">${escBusqueda(nombre.charAt(0).toUpperCase())}</div>
            <div>
                <p class="font-bold text-slate-800">${escBusqueda(nombre)}</p>
                <p class="text-xs text-slate-500">${historial.length} cita${historial.length != 1 ? 's' : ''} registrada${historial.length != 1 ? 's' : ''}</p>
            </div>
        </div>
        ${historial.length === 0 ? `<p class="text-center text-slate-400 text-sm py-4">Sin citas registradas.</p>` :
        historial.map(c => `
            <div class="p-4 bg-slate-50 rounded-xl border border-slate-100 space-y-1 mb-2">
                <div class="flex items-center justify-between">
                    <span class="text-sm font-bold text-slate-700">${c.fecha} · ${c.hora.slice(0,5)}</span>
                    <span class="text-xs font-bold px-2 py-0.5 rounded-full ${estadoColor[c.estado] || 'bg-slate-100 text-slate-600'}">${c.estado}</span>
                </div>
                ${c.motivo_consulta ? `<p class="text-xs text-slate-500">Motivo: ${escBusqueda(c.motivo_consulta)}</p>` : ''}
                ${c.notas_sesion ? `<p class="text-xs text-slate-400 italic">Notas: ${escBusqueda(c.notas_sesion)}</p>` : ''}
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
