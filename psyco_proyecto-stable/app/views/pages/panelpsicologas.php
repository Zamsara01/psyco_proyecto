<?php
/**
 * Vista: Panel Psicólogas
 * Variables: $stats[], $citasRecientes[], $citasHoy[], $pacientesHoy[]
 */
?>
<div class="p-6 md:p-8 flex-1">

<!-- ══════════ BARRA DE ACCIONES RÁPIDAS ══════════ -->
    <div class="flex flex-wrap items-start justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900">Mi Panel</h1>
            <p class="text-sm text-slate-500 mt-0.5">Bienvenida, <?= htmlspecialchars($_SESSION['user']['nombre'] ?? 'Psicóloga') ?> 👋</p>
        </div>
        <div class="flex flex-wrap gap-2 sm:gap-3 w-full sm:w-auto">
            <button onclick="abrirModalDisponibilidad()"
                id="btn-disponibilidad"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 rounded-xl border-2 border-indigo-200 text-indigo-600 font-bold text-sm hover:bg-indigo-50 hover:border-indigo-400 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">schedule</span>
                <span class="hidden xs:inline sm:inline">Mi Disponibilidad</span>
                <span class="xs:hidden sm:hidden">Disponibilidad</span>
            </button>
            <button onclick="abrirModalCrearPaciente()"
                id="btn-crear-paciente"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 rounded-xl border-2 border-orange-200 text-orange-600 font-bold text-sm hover:bg-orange-50 hover:border-orange-400 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span>Crear Paciente</span>
            </button>
            <button onclick="abrirModalAgendarCita()"
                id="btn-agendar-cita"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 rounded-xl bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold text-sm hover:from-orange-600 hover:to-amber-600 shadow-md shadow-orange-200 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">calendar_add_on</span>
                <span>Agendar Cita</span>
            </button>
        </div>
    </div>

    <!-- ══════════ STATS ROW ══════════ -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

        <!-- Sesiones este mes -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-orange-100 text-orange-600 rounded-xl">
                    <span class="material-symbols-outlined">clinical_notes</span>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-full">Este mes</span>
            </div>
            <p class="text-slate-500 text-sm font-medium">Sesiones este mes</p>
            <h3 class="text-3xl font-black text-slate-900 mt-1"><?= (int)($stats['sesiones_mes'] ?? 0) ?></h3>
        </div>

        <!-- Citas Pendientes -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 text-blue-600 rounded-xl">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-full">Próximas</span>
            </div>
            <p class="text-slate-500 text-sm font-medium">Citas Pendientes</p>
            <h3 class="text-3xl font-black text-slate-900 mt-1"><?= (int)($stats['pendientes_hoy'] ?? 0) ?></h3>
        </div>

        <!-- Sesiones Completadas -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 text-green-600 rounded-xl">
                    <span class="material-symbols-outlined">task_alt</span>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-50 px-2 py-1 rounded-full">Este mes</span>
            </div>
            <p class="text-slate-500 text-sm font-medium">Sesiones Completadas</p>
            <h3 class="text-3xl font-black text-slate-900 mt-1"><?= (int)($stats['altas_medicas'] ?? 0) ?></h3>
        </div>
    </div>

    <!-- ══════════ TABLA DE PACIENTES RECIENTES ══════════ -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-50 flex justify-between items-center bg-slate-50/30">
            <h2 class="text-lg font-bold text-slate-900">Citas Recientes de mis Pacientes</h2>
            <span class="text-xs text-slate-400"><?= count($citasRecientes) ?> registros</span>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50">
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Paciente</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Motivo / Estado</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Fecha</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider">Notas</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody class="divide-y divide-slate-100">
                    <?php if (empty($citasRecientes)): ?>
                    <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400 text-sm">No hay citas registradas.</td></tr>
                    <?php else: ?>
                        <?php foreach ($citasRecientes as $i => $cita):
                            $partes   = explode(' ', $cita['paciente_nombre']);
                            $iniciales = count($partes) >= 2
                                ? strtoupper(substr($partes[0],0,1).substr($partes[1],0,1))
                                : strtoupper(substr($cita['paciente_nombre'],0,2));
                            $fechaF  = date('d M Y', strtotime($cita['fecha']));
                            $colores = ['pendiente'=>'bg-blue-100 text-blue-700','completada'=>'bg-green-100 text-green-700','cancelada'=>'bg-red-100 text-red-700','en proceso'=>'bg-yellow-100 text-yellow-700'];
                            $estadoColor = $colores[$cita['estado']] ?? 'bg-slate-100 text-slate-600';
                        ?>
                        <tr class="hover:bg-orange-50/20 transition-colors">
                            <td class="px-5 py-4 text-sm font-medium text-slate-400"><?= $i + 1 ?></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-orange-100 text-orange-600 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= htmlspecialchars($iniciales) ?>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900"><?= htmlspecialchars($cita['paciente_nombre']) ?></p>
                                        <p class="text-xs text-slate-400"><?= htmlspecialchars($cita['correo_electronico']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold <?= $estadoColor ?>">
                                    <?= htmlspecialchars(substr($cita['motivo_consulta'] ?? 'Sin motivo', 0, 35)) ?><?= strlen($cita['motivo_consulta'] ?? '') > 35 ? '…' : '' ?>
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-600"><?= $fechaF ?> <span class="text-slate-400">· <?= substr($cita['hora'],0,5) ?></span></td>
                            <td class="px-5 py-4 text-sm text-slate-500 max-w-[200px] truncate">
                                <?= htmlspecialchars($cita['notas_sesion'] ? substr($cita['notas_sesion'], 0, 50) . (strlen($cita['notas_sesion']) > 50 ? '…' : '') : '—') ?>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <button onclick="abrirNotaRapida(<?= $cita['id_usuario'] ?>, '<?= htmlspecialchars(addslashes($cita['paciente_nombre'])) ?>')"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-orange-600 hover:bg-orange-50 transition-colors" title="Agregar nota">
                                    <span class="material-symbols-outlined text-[18px]">note_add</span>
                                </button>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>

    <!-- ══════════ FILA INFERIOR: Citas Hoy + Notas Pacientes ══════════ -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">

        <!-- Citas para Hoy -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-900 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-orange-500">event_upcoming</span>
                Citas para Hoy
                <span class="ml-auto text-xs text-slate-400 font-normal"><?= date('d M Y') ?></span>
            </h3>
            <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1">
                <?php if (empty($citasHoy)): ?>
                    <div class="p-6 text-center text-slate-400 border border-dashed border-slate-200 rounded-xl text-sm">
                        🎉 Sin citas pendientes hoy. ¡Día libre!
                    </div>
                <?php else: ?>
                    <?php foreach ($citasHoy as $c):
                        $horaF = date('h:i', strtotime($c['hora']));
                        $amPm  = date('A', strtotime($c['hora']));
                    ?>
                    <div class="flex items-center gap-4 p-3.5 rounded-xl border border-slate-100 hover:border-orange-100 hover:bg-orange-50/20 transition-all">
                        <div class="text-center w-14 shrink-0">
                            <p class="text-xs font-black text-orange-600 uppercase"><?= $horaF ?></p>
                            <p class="text-[10px] text-slate-400"><?= $amPm ?></p>
                        </div>
                        <div class="w-[2px] h-8 bg-orange-200 shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-900 truncate"><?= htmlspecialchars($c['paciente_nombre']) ?></p>
                            <p class="text-xs text-slate-500 truncate"><?= htmlspecialchars($c['motivo_consulta'] ?? 'Sin motivo específico') ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Notas para los Pacientes de Hoy -->
        <div class="bg-white p-6 rounded-2xl shadow-sm border border-slate-100">
            <h3 class="font-bold text-slate-900 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-purple-500">sticky_note_2</span>
                <a href="<?= URL_BASE ?>panel_psicologas/notasPacientes"
                   class="hover:text-purple-600 transition-colors">Notas para Pacientes de Hoy</a>
                <span class="ml-auto text-xs text-slate-400 font-normal"><?= count($pacientesHoy) ?> paciente(s)</span>
            </h3>

            <?php if (empty($pacientesHoy)): ?>
                <div class="p-6 text-center text-slate-400 border border-dashed border-slate-200 rounded-xl text-sm">
                    No hay pacientes programados para hoy.
                </div>
            <?php else: ?>
                <!-- Selector de paciente -->
                <div class="flex gap-2 flex-wrap mb-4">
                    <?php foreach ($pacientesHoy as $idx => $pac): ?>
                    <button onclick="seleccionarPacienteNotas(<?= $pac['id_usuario'] ?>, '<?= htmlspecialchars(addslashes($pac['paciente_nombre'])) ?>', this)"
                        class="paciente-notas-btn text-xs font-semibold px-3 py-1.5 rounded-full border-2 transition-all
                               <?= $idx === 0 ? 'border-purple-500 bg-purple-500 text-white' : 'border-slate-200 text-slate-500 hover:border-purple-300 hover:text-purple-600' ?>">
                        <?= htmlspecialchars($pac['paciente_nombre']) ?>
                        <?php if ($pac['total_notas'] > 0): ?>
                        <span class="ml-1 text-[10px] opacity-75">(<?= $pac['total_notas'] ?>)</span>
                        <?php endif; ?>
                    </button>
                    <?php endforeach; ?>
                </div>

                <!-- Notas del paciente seleccionado -->
                <div id="notasPacienteContainer" class="space-y-2 max-h-[220px] overflow-y-auto pr-1">
                    <div class="text-center py-6 text-slate-400 text-sm">
                        <div class="w-6 h-6 border-3 border-purple-200 border-t-purple-400 rounded-full animate-spin mx-auto mb-2"></div>
                        Cargando notas...
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- ══════════ MODAL: NOTA RÁPIDA ══════════ -->
<div id="notaRapidaModal" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cerrarNotaRapida()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 z-10 p-7">
        <button onclick="cerrarNotaRapida()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="font-bold text-slate-800 text-lg mb-1">Nueva nota</h3>
        <p id="notaRapidaPacienteNombre" class="text-sm text-purple-500 font-medium mb-5"></p>
        <input type="hidden" id="notaRapidaIdUsuario">

        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Título</label>
                <input type="text" id="notaRapidaTitulo" placeholder="Ej: Ejercicio de respiración"
                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-purple-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-1.5">Contenido</label>
                <textarea id="notaRapidaContenido" rows="4" placeholder="Escribe la nota o recomendación para el paciente..."
                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
            </div>
        </div>

        <div id="notaRapidaError" class="hidden mt-3 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600"></div>

        <button onclick="guardarNotaRapida()"
            class="w-full mt-5 py-3 bg-gradient-to-r from-purple-500 to-violet-600 text-white font-bold rounded-xl hover:from-purple-600 hover:to-violet-700 transition-all active:scale-[0.98]">
            Guardar nota
        </button>
    </div>
</div>

<script>
const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');

// ─── Cargar notas al montar ──────────────────────────────────────
window.addEventListener('DOMContentLoaded', () => {
    const primerBtn = document.querySelector('.paciente-notas-btn');
    if (primerBtn) primerBtn.click();
});

async function seleccionarPacienteNotas(idUsuario, nombre, btn) {
    document.querySelectorAll('.paciente-notas-btn').forEach(b => {
        b.classList.remove('border-purple-500','bg-purple-500','text-white');
        b.classList.add('border-slate-200','text-slate-500');
    });
    btn.classList.add('border-purple-500','bg-purple-500','text-white');
    btn.classList.remove('border-slate-200','text-slate-500');

    const container = document.getElementById('notasPacienteContainer');
    container.innerHTML = `<div class="flex justify-center py-4"><div class="w-6 h-6 border-3 border-purple-200 border-t-purple-400 rounded-full animate-spin"></div></div>`;

    try {
        const res  = await fetch(BASE + 'panel_psicologas/notasPaciente?id_usuario=' + idUsuario);
        const data = await res.json();
        if (!data.ok) throw new Error(data.error);

        if (!data.notas.length) {
            container.innerHTML = `<p class="text-center text-slate-400 text-sm py-4">Sin notas para ${esc(nombre)}. <button onclick="abrirNotaRapida(${idUsuario}, '${esc(nombre)}')" class="text-purple-500 hover:underline font-semibold">+ Agregar</button></p>`;
            return;
        }
        container.innerHTML = data.notas.map(n => `
            <div class="p-3 bg-purple-50 rounded-xl border border-purple-100">
                <div class="flex items-start justify-between gap-2">
                    <p class="text-sm font-bold text-slate-800">${esc(n.titulo)}</p>
                    <p class="text-[10px] text-slate-400 shrink-0">${n.fecha_creacion?.slice(0,10) || ''}</p>
                </div>
                <p class="text-xs text-slate-600 mt-1 leading-relaxed">${esc(n.contenido)}</p>
            </div>
        `).join('') + `<button onclick="abrirNotaRapida(${idUsuario}, '${esc(nombre)}')" class="w-full mt-2 py-2 text-xs font-semibold text-purple-500 hover:bg-purple-50 rounded-xl border-2 border-dashed border-purple-200 transition-colors">+ Nueva nota</button>`;
    } catch(e) {
        container.innerHTML = `<p class="text-red-400 text-sm text-center py-4">Error: ${e.message}</p>`;
    }
}

// ─── Modal: Nota Rápida ──────────────────────────────────────────
function abrirNotaRapida(idUsuario, nombre) {
    document.getElementById('notaRapidaIdUsuario').value = idUsuario;
    document.getElementById('notaRapidaPacienteNombre').textContent = nombre;
    document.getElementById('notaRapidaTitulo').value = '';
    document.getElementById('notaRapidaContenido').value = '';
    document.getElementById('notaRapidaError').classList.add('hidden');
    document.getElementById('notaRapidaModal').classList.remove('hidden');
    document.getElementById('notaRapidaModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function cerrarNotaRapida() {
    document.getElementById('notaRapidaModal').classList.add('hidden');
    document.getElementById('notaRapidaModal').classList.remove('flex');
    document.body.style.overflow = '';
}

async function guardarNotaRapida() {
    const idUsuario = document.getElementById('notaRapidaIdUsuario').value;
    const titulo    = document.getElementById('notaRapidaTitulo').value.trim();
    const contenido = document.getElementById('notaRapidaContenido').value.trim();
    const errEl     = document.getElementById('notaRapidaError');

    if (!titulo || !contenido) {
        errEl.textContent = 'Completa el título y el contenido.';
        errEl.classList.remove('hidden');
        return;
    }
    errEl.classList.add('hidden');

    try {
        const res  = await fetch(BASE + 'panel_psicologas/crearNota', {
            method: 'POST', headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ id_usuario: parseInt(idUsuario), titulo, contenido })
        });
        const data = await res.json();
        if (data.ok) {
            cerrarNotaRapida();
            // Recargar notas del paciente activo
            const btn = document.querySelector('.paciente-notas-btn.bg-purple-500');
            if (btn) btn.click();
        } else {
            errEl.textContent = data.error;
            errEl.classList.remove('hidden');
        }
    } catch(e) {
        errEl.textContent = 'Error de conexión.';
        errEl.classList.remove('hidden');
    }
}

function esc(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;').replace(/'/g,'&#39;');
}

window.URL_BASE = '<?= URL_BASE ?>';
</script>

<!-- ══════════ MODAL: AGENDAR CITA ══════════ -->
<div id="modalAgendarCita" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalAgendarCita()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-lg mx-4 z-10 p-7 max-h-[92vh] overflow-y-auto">
        <button onclick="cerrarModalAgendarCita()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-orange-100 rounded-2xl">
                <span class="material-symbols-outlined text-orange-500 text-2xl">calendar_add_on</span>
            </div>
            <div>
                <h3 class="font-black text-slate-800 text-xl">Agendar Cita</h3>
                <p class="text-sm text-slate-400">Programa una sesión para un paciente</p>
            </div>
        </div>

        <!-- Buscador de paciente -->
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Paciente <span class="text-red-400">*</span></label>
                <div class="relative">
                    <input type="text" id="agendarBuscadorInput" placeholder="Buscar por nombre o correo..."
                        autocomplete="off"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors pr-10">
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 text-[20px]">search</span>
                </div>
                <div id="agendarResultadosPacientes" class="hidden mt-1 bg-white border border-slate-200 rounded-xl shadow-lg overflow-hidden max-h-48 overflow-y-auto z-20 relative"></div>
                <input type="hidden" id="agendarIdUsuario">
                <p id="agendarPacienteSeleccionado" class="hidden mt-2 text-xs font-semibold text-orange-600 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span id="agendarPacienteNombre"></span>
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Fecha <span class="text-red-400">*</span></label>
                    <input type="date" id="agendarFecha" min="<?= date('Y-m-d') ?>"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Hora <span class="text-red-400">*</span></label>
                    <select id="agendarHora" disabled
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors bg-white disabled:opacity-50 disabled:cursor-not-allowed">
                        <option value="">Elige una fecha primero</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Motivo de Consulta</label>
                <textarea id="agendarMotivo" rows="3" placeholder="Describe el motivo principal de la sesión..."
                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-orange-400 transition-colors resize-none"></textarea>
            </div>
        </div>

        <div id="agendarError" class="hidden mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
            <span id="agendarErrorMsg"></span>
        </div>
        <div id="agendarSuccess" class="hidden mt-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">check_circle</span>
            <span id="agendarSuccessMsg"></span>
        </div>

        <button onclick="guardarCitaAgendada()" id="btnGuardarCita"
            class="w-full mt-5 py-3 bg-gradient-to-r from-orange-500 to-amber-500 text-white font-bold rounded-xl hover:from-orange-600 hover:to-amber-600 transition-all active:scale-[0.98] shadow-md shadow-orange-200 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[20px]">event_available</span>
            Confirmar Cita
        </button>
    </div>
</div>

<!-- ══════════ MODAL: CREAR PACIENTE ══════════ -->
<div id="modalCrearPaciente" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalCrearPaciente()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-xl mx-4 z-10 p-7 max-h-[92vh] overflow-y-auto">
        <button onclick="cerrarModalCrearPaciente()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-blue-100 rounded-2xl">
                <span class="material-symbols-outlined text-blue-500 text-2xl">person_add</span>
            </div>
            <div>
                <h3 class="font-black text-slate-800 text-xl">Nuevo Paciente</h3>
                <p class="text-sm text-slate-400">Registrar paciente desde el panel</p>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Datos básicos -->
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2">Datos del Paciente</p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Grado <span class="text-red-400">*</span></label>
                    <select id="cpGrado" class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors bg-white">
                        <option value="">Seleccionar</option>
                        <?php foreach(['6','7','8','9','10','11'] as $g): ?>
                        <option value="<?= $g ?>">Grado <?= $g ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nombre Completo <span class="text-red-400">*</span></label>
                    <input type="text" id="cpNombre" placeholder="Nombre del paciente"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Correo Electrónico <span class="text-red-400">*</span></label>
                <input type="email" id="cpCorreo" placeholder="correo@ejemplo.com"
                    class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Contraseña <span class="text-red-400">*</span></label>
                    <input type="password" id="cpContrasena" placeholder="Contraseña inicial"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Confirmar Contraseña <span class="text-red-400">*</span></label>
                    <input type="password" id="cpContrasena2" placeholder="Repetir contraseña"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>

            <!-- Datos acudiente -->
            <p class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2 mt-2">Datos del Acudiente <span class="font-normal text-slate-300">(opcional)</span></p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Nombre Acudiente</label>
                    <input type="text" id="cpAcudNombre" placeholder="Nombre completo"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Cédula</label>
                    <input type="text" id="cpAcudCedula" placeholder="Solo números"
                        inputmode="numeric" pattern="[0-9]*"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Relación</label>
                    <select id="cpAcudRelacion" class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors bg-white">
                        <option value="">Seleccionar</option>
                        <option value="Padre">Padre</option>
                        <option value="Madre">Madre</option>
                        <option value="Tutor legal">Tutor legal</option>
                        <option value="Hermano/a">Hermano/a</option>
                        <option value="Abuelo/a">Abuelo/a</option>
                        <option value="Otro">Otro</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Correo Acudiente</label>
                    <input type="email" id="cpAcudCorreo" placeholder="correo@ejemplo.com"
                        class="w-full border-2 border-slate-200 rounded-xl px-4 py-2.5 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
        </div>

        <div id="cpError" class="hidden mt-4 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
            <span id="cpErrorMsg"></span>
        </div>
        <div id="cpSuccess" class="hidden mt-4 p-3 bg-green-50 border border-green-200 rounded-xl text-sm text-green-700 flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">check_circle</span>
            <span id="cpSuccessMsg"></span>
        </div>

        <button onclick="guardarNuevoPaciente()" id="btnGuardarPaciente"
            class="w-full mt-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all active:scale-[0.98] shadow-md shadow-blue-200 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[20px]">person_check</span>
            Registrar Paciente
        </button>
    </div>
</div>

<script>
// ── Helpers ─────────────────────────────────────────────────────────────────
function mostrarError(elId, msgId, msg) {
    document.getElementById(msgId).textContent = msg;
    document.getElementById(elId).classList.remove('hidden');
    document.getElementById(elId).classList.add('flex');
}
function ocultarError(elId) {
    document.getElementById(elId).classList.add('hidden');
    document.getElementById(elId).classList.remove('flex');
}
function mostrarSuccess(elId, msgId, msg) {
    document.getElementById(msgId).textContent = msg;
    document.getElementById(elId).classList.remove('hidden');
    document.getElementById(elId).classList.add('flex');
}

// ══════════════════════════════════════════════════════════════════════════════
// MODAL: AGENDAR CITA
// ══════════════════════════════════════════════════════════════════════════════
function abrirModalAgendarCita() {
    resetModalAgendar();
    const m = document.getElementById('modalAgendarCita');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function cerrarModalAgendarCita() {
    const m = document.getElementById('modalAgendarCita');
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}
function resetModalAgendar() {
    document.getElementById('agendarBuscadorInput').value = '';
    document.getElementById('agendarIdUsuario').value = '';
    document.getElementById('agendarFecha').value = '';
    document.getElementById('agendarMotivo').value = '';
    document.getElementById('agendarHora').innerHTML = '<option value="">Elige una fecha primero</option>';
    document.getElementById('agendarHora').disabled = true;
    document.getElementById('agendarResultadosPacientes').classList.add('hidden');
    document.getElementById('agendarPacienteSeleccionado').classList.add('hidden');
    ocultarError('agendarError');
    ocultarError('agendarSuccess');
}

// Autocomplete pacientes
let debounceTimer;
document.addEventListener('DOMContentLoaded', () => {
    const input = document.getElementById('agendarBuscadorInput');
    if (!input) return;

    input.addEventListener('input', () => {
        clearTimeout(debounceTimer);
        const q = input.value.trim();
        const lista = document.getElementById('agendarResultadosPacientes');
        if (q.length < 2) { lista.classList.add('hidden'); return; }

        debounceTimer = setTimeout(async () => {
            const res  = await fetch(BASE + 'panel_psicologas/buscarTodosLosPacientes?q=' + encodeURIComponent(q));
            const data = await res.json();
            if (!data.ok || !data.pacientes.length) {
                lista.innerHTML = '<p class="px-4 py-3 text-sm text-slate-400">Sin resultados.</p>';
                lista.classList.remove('hidden');
                return;
            }
            lista.innerHTML = data.pacientes.map(p => `
                <button type="button" onclick="seleccionarPacienteAgendar(${p.id_usuario}, '${esc(p.nombre)}', '${esc(p.correo_electronico)}')"
                    class="w-full text-left px-4 py-2.5 hover:bg-orange-50 transition-colors border-b border-slate-100 last:border-0">
                    <p class="text-sm font-bold text-slate-800">${esc(p.nombre)}</p>
                    <p class="text-xs text-slate-400">${esc(p.correo_electronico)} · Grado ${esc(p.grado)}</p>
                </button>`).join('');
            lista.classList.remove('hidden');
        }, 350);
    });
});

function seleccionarPacienteAgendar(id, nombre, correo) {
    document.getElementById('agendarIdUsuario').value = id;
    document.getElementById('agendarBuscadorInput').value = nombre + ' — ' + correo;
    document.getElementById('agendarPacienteNombre').textContent = nombre;
    document.getElementById('agendarPacienteSeleccionado').classList.remove('hidden');
    document.getElementById('agendarResultadosPacientes').classList.add('hidden');
}

// Cargar horas disponibles al cambiar fecha
document.addEventListener('DOMContentLoaded', () => {
    const fechaInput = document.getElementById('agendarFecha');
    if (!fechaInput) return;
    fechaInput.addEventListener('change', async () => {
        const fecha = fechaInput.value;
        const horaSelect = document.getElementById('agendarHora');
        horaSelect.innerHTML = '<option value="">Cargando...</option>';
        horaSelect.disabled = true;
        if (!fecha) return;

        const res  = await fetch(BASE + 'panel_psicologas/horasDisponiblesAgenda?fecha=' + fecha);
        const data = await res.json();
        if (!data.ok || !data.horas.length) {
            horaSelect.innerHTML = '<option value="">Sin disponibilidad ese día</option>';
            return;
        }
        horaSelect.innerHTML = '<option value="">Seleccionar hora</option>' +
            data.horas.map(h => `<option value="${h}">${h}</option>`).join('');
        horaSelect.disabled = false;
    });
});

async function guardarCitaAgendada() {
    ocultarError('agendarError');
    ocultarError('agendarSuccess');

    const idUsuario = document.getElementById('agendarIdUsuario').value;
    const fecha     = document.getElementById('agendarFecha').value;
    const hora      = document.getElementById('agendarHora').value;
    const motivo    = document.getElementById('agendarMotivo').value.trim();

    if (!idUsuario) { mostrarError('agendarError','agendarErrorMsg','Selecciona un paciente.'); return; }
    if (!fecha)     { mostrarError('agendarError','agendarErrorMsg','Elige una fecha.'); return; }
    if (!hora)      { mostrarError('agendarError','agendarErrorMsg','Selecciona una hora disponible.'); return; }

    const btn = document.getElementById('btnGuardarCita');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span> Guardando...';

    try {
        const res  = await fetch(BASE + 'panel_psicologas/agendarCita', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ id_usuario: parseInt(idUsuario), fecha, hora, motivo_consulta: motivo })
        });
        const data = await res.json();
        if (data.ok) {
            mostrarSuccess('agendarSuccess','agendarSuccessMsg', data.mensaje);
            setTimeout(() => { cerrarModalAgendarCita(); location.reload(); }, 1800);
        } else {
            mostrarError('agendarError','agendarErrorMsg', data.error);
        }
    } catch(e) {
        mostrarError('agendarError','agendarErrorMsg','Error de conexión.');
    }

    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">event_available</span> Confirmar Cita';
}

// ══════════════════════════════════════════════════════════════════════════════
// MODAL: CREAR PACIENTE
// ══════════════════════════════════════════════════════════════════════════════
function abrirModalCrearPaciente() {
    resetModalCrearPaciente();
    const m = document.getElementById('modalCrearPaciente');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}
function cerrarModalCrearPaciente() {
    const m = document.getElementById('modalCrearPaciente');
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}
function resetModalCrearPaciente() {
    ['cpGrado','cpNombre','cpCorreo','cpContrasena','cpContrasena2',
     'cpAcudNombre','cpAcudCedula','cpAcudRelacion','cpAcudCorreo'].forEach(id => {
        const el = document.getElementById(id);
        if (el) el.value = '';
    });
    ocultarError('cpError');
    ocultarError('cpSuccess');
}

async function guardarNuevoPaciente() {
    ocultarError('cpError');
    ocultarError('cpSuccess');

    const grado      = document.getElementById('cpGrado').value;
    const nombre     = document.getElementById('cpNombre').value.trim();
    const correo     = document.getElementById('cpCorreo').value.trim();
    const contrasena = document.getElementById('cpContrasena').value;
    const contrasena2= document.getElementById('cpContrasena2').value;
    const acudNombre = document.getElementById('cpAcudNombre').value.trim();
    const acudCedula = document.getElementById('cpAcudCedula').value.trim();
    const acudRelacion = document.getElementById('cpAcudRelacion').value;
    const acudCorreo = document.getElementById('cpAcudCorreo').value.trim();

    if (!grado || !nombre || !correo || !contrasena) {
        mostrarError('cpError','cpErrorMsg','Grado, nombre, correo y contraseña son obligatorios.');
        return;
    }
    if (contrasena !== contrasena2) {
        mostrarError('cpError','cpErrorMsg','Las contraseñas no coinciden.');
        return;
    }
    if (acudCedula && !/^\d+$/.test(acudCedula)) {
        mostrarError('cpError','cpErrorMsg','La cédula del acudiente solo puede contener números.');
        return;
    }

    const btn = document.getElementById('btnGuardarPaciente');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[20px]">progress_activity</span> Registrando...';

    try {
        const res  = await fetch(BASE + 'panel_psicologas/crearPaciente', {
            method: 'POST',
            headers: {'Content-Type':'application/json'},
            body: JSON.stringify({
                grado, nombre, correo_electronico: correo, contrasena,
                acudiente_nombre: acudNombre, acudiente_cedula: acudCedula,
                acudiente_relacion: acudRelacion, acudiente_correo: acudCorreo
            })
        });
        const data = await res.json();
        if (data.ok) {
            mostrarSuccess('cpSuccess','cpSuccessMsg', data.mensaje);
            setTimeout(resetModalCrearPaciente, 2500);
        } else {
            mostrarError('cpError','cpErrorMsg', data.error);
        }
    } catch(e) {
        mostrarError('cpError','cpErrorMsg','Error de conexión.');
    }

    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-outlined text-[20px]">person_check</span> Registrar Paciente';
}
// ══════════════════════════════════════════════════════════════════════════════
// MODAL: GESTIONAR DISPONIBILIDAD
// ══════════════════════════════════════════════════════════════════════════════
function abrirModalDisponibilidad() {
    const m = document.getElementById('modalDisponibilidad');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    cargarDisponibilidad();
}

function cerrarModalDisponibilidad() {
    const m = document.getElementById('modalDisponibilidad');
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}

async function cargarDisponibilidad() {
    const container = document.getElementById('dispListaContainer');
    container.innerHTML = `
        <div class="text-center py-6 text-slate-400 text-sm">
            <div class="w-6 h-6 border-3 border-indigo-200 border-t-indigo-500 rounded-full animate-spin mx-auto mb-2"></div>
            Cargando horarios...
        </div>`;

    try {
        const res = await fetch(BASE + 'panel_psicologas/obtenerDisponibilidad');
        const data = await res.json();
        
        if (!data.ok) {
            container.innerHTML = `<p class="text-center py-6 text-sm text-red-500">${esc(data.error)}</p>`;
            return;
        }

        const dispo = data.disponibilidad;
        if (!dispo.length) {
            container.innerHTML = `
                <div class="p-6 text-center text-slate-400 border border-dashed border-slate-200 rounded-xl text-sm">
                    No tienes horarios de disponibilidad configurados.
                </div>`;
            return;
        }

        // Agrupar por día
        const diasSemana = ['Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado', 'Domingo'];
        const agrupado = {};
        diasSemana.forEach(d => agrupado[d] = []);
        dispo.forEach(d => {
            if (agrupado[d.dia_semana]) {
                agrupado[d.dia_semana].push(d);
            }
        });

        let html = '';
        diasSemana.forEach(dia => {
            const bloques = agrupado[dia];
            if (bloques.length > 0) {
                html += `
                    <div class="border border-slate-100 rounded-2xl p-4 bg-slate-50/50">
                        <h5 class="font-bold text-slate-800 text-sm mb-3 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            ${esc(dia)}
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            ${bloques.map(b => `
                                <div class="flex items-center justify-between bg-white border border-slate-100 rounded-xl px-3 py-2 text-sm shadow-sm hover:border-slate-200 transition-colors">
                                    <span class="font-semibold text-slate-600">${esc(b.hora_inicio)} - ${esc(b.hora_fin)}</span>
                                    <button onclick="eliminarHorario(${b.id_disponibilidad})" class="p-1 rounded-lg text-slate-400 hover:text-red-500 hover:bg-red-50 transition-all active:scale-90" title="Eliminar bloque">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            `).join('')}
                        </div>
                    </div>`;
            }
        });
        container.innerHTML = html || `
            <div class="p-6 text-center text-slate-400 border border-dashed border-slate-200 rounded-xl text-sm">
                No tienes horarios de disponibilidad configurados.
            </div>`;
    } catch(e) {
        container.innerHTML = `<p class="text-center py-6 text-sm text-red-500">Error al conectar con el servidor.</p>`;
    }
}

async function agregarHorarioDisponibilidad() {
    const errorCont = document.getElementById('dispFormError');
    const errorMsg = document.getElementById('dispFormErrorMsg');
    errorCont.classList.add('hidden');

    const dia = document.getElementById('dispDia').value;
    const inicio = document.getElementById('dispInicio').value;
    const fin = document.getElementById('dispFin').value;

    if (!dia || !inicio || !fin) {
        errorMsg.textContent = 'Selecciona el día, hora de inicio y fin.';
        errorCont.classList.remove('hidden');
        return;
    }

    const tInicio = new Date(`2000-01-01T${inicio}`);
    const tFin = new Date(`2000-01-01T${fin}`);
    if (tInicio >= tFin) {
        errorMsg.textContent = 'La hora de inicio debe ser anterior a la hora de fin.';
        errorCont.classList.remove('hidden');
        return;
    }

    const btn = document.getElementById('btnAgregarDisp');
    btn.disabled = true;
    btn.innerHTML = '<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span> Guardando...';

    try {
        const res = await fetch(BASE + 'panel_psicologas/agregarDisponibilidad', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ dia_semana: dia, hora_inicio: inicio, hora_fin: fin })
        });
        const data = await res.json();
        if (data.ok) {
            cargarDisponibilidad();
            document.getElementById('dispInicio').value = '';
            document.getElementById('dispFin').value = '';
        } else {
            errorMsg.textContent = data.error;
            errorCont.classList.remove('hidden');
        }
    } catch(e) {
        errorMsg.textContent = 'Error de conexión.';
        errorCont.classList.remove('hidden');
    }
    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">add_circle</span> Agregar a mi horario';
}

async function eliminarHorario(idDisponibilidad) {
    if (!confirm('¿Estás segura de que deseas eliminar este bloque de disponibilidad?')) return;
    
    try {
        const res = await fetch(BASE + 'panel_psicologas/eliminarDisponibilidad', {
            method: 'POST',
            headers: {'Content-Type': 'application/json'},
            body: JSON.stringify({ id_disponibilidad: idDisponibilidad })
        });
        const data = await res.json();
        if (data.ok) {
            cargarDisponibilidad();
        } else {
            alert(data.error);
        }
    } catch(e) {
        alert('Error de conexión.');
    }
}
</script>

<!-- ══════════ MODAL: GESTIONAR DISPONIBILIDAD (HTML) ══════════ -->
<div id="modalDisponibilidad" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalDisponibilidad()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-2xl mx-4 z-10 p-7 max-h-[92vh] overflow-y-auto">
        <button onclick="cerrarModalDisponibilidad()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-indigo-100 rounded-2xl">
                <span class="material-symbols-outlined text-indigo-600 text-2xl">schedule</span>
            </div>
            <div>
                <h3 class="font-black text-slate-800 text-xl">Mi Disponibilidad</h3>
                <p class="text-sm text-slate-400">Configura tus bloques de horarios semanales</p>
            </div>
        </div>

        <!-- Agregar nuevo horario -->
        <div class="bg-indigo-50/50 border border-indigo-100 rounded-2xl p-4 mb-6">
            <h4 class="text-xs font-bold text-indigo-800 uppercase tracking-wider mb-3">Agregar Bloque de Horario</h4>
            <div class="grid grid-cols-1 sm:grid-cols-3 gap-3 items-end">
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Día de la Semana</label>
                    <select id="dispDia" class="w-full border-2 border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-indigo-400 transition-colors bg-white">
                        <option value="Lunes">Lunes</option>
                        <option value="Martes">Martes</option>
                        <option value="Miércoles">Miércoles</option>
                        <option value="Jueves">Jueves</option>
                        <option value="Viernes">Viernes</option>
                        <option value="Sábado">Sábado</option>
                        <option value="Domingo">Domingo</option>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Hora Inicio</label>
                    <input type="time" id="dispInicio" step="1800"
                        class="w-full border-2 border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-indigo-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 uppercase tracking-wider mb-1.5">Hora Fin</label>
                    <input type="time" id="dispFin" step="1800"
                        class="w-full border-2 border-slate-200 rounded-xl px-3 py-2 text-sm focus:outline-none focus:border-indigo-400 transition-colors">
                </div>
            </div>
            
            <div id="dispFormError" class="hidden mt-3 p-2.5 bg-red-50 border border-red-200 rounded-xl text-xs text-red-600 flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px] shrink-0">error</span>
                <span id="dispFormErrorMsg"></span>
            </div>

            <button onclick="agregarHorarioDisponibilidad()" id="btnAgregarDisp"
                class="w-full mt-4 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all active:scale-[0.98] flex items-center justify-center gap-2 text-sm">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Agregar a mi horario
            </button>
        </div>

        <!-- Lista de disponibilidad agrupada por días -->
        <div>
            <h4 class="text-xs font-bold text-slate-400 uppercase tracking-wider border-b border-slate-100 pb-2 mb-3">Mis Horarios Activos</h4>
            <div id="dispListaContainer" class="space-y-4 max-h-[40vh] overflow-y-auto pr-1">
                <!-- Se llena vía JS -->
            </div>
        </div>
    </div>
</div>

