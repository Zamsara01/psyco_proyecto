<?php
/**
 * Vista: Panel Psicólogas
 * Variables: $stats[], $citasRecientes[], $citasHoy[], $pacientesHoy[], $citaEnProceso
 */
?>
<div class="p-6 md:p-8 flex-1">

<!-- ══════════ BARRA DE ACCIONES RÁPIDAS ══════════ -->
    <div class="flex flex-wrap items-start justify-between gap-4 mb-8">
        <div>
            <h1 class="text-xl sm:text-2xl font-black text-slate-900 dark:text-slate-100">Mi Panel</h1>
            <p class="text-sm text-slate-500 dark:text-slate-400 mt-0.5">Bienvenida, <?= htmlspecialchars($_SESSION['user']['nombre'] ?? 'Psicóloga') ?> 👋</p>
        </div>
        <div class="flex flex-wrap gap-2 sm:gap-3 w-full sm:w-auto">

            <?php if ($citaEnProceso && $citaOcurriendo): ?>
            <!-- Botón Finalizar Reunión ACTIVO (solo cuando la cita está ocurriendo AHORA) -->
            <button id="btn-finalizar-reunion" onclick="finalizarReunion()"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl bg-gradient-to-r from-red-500 to-rose-600 text-white font-bold text-sm hover:from-red-600 hover:to-rose-700 shadow-md shadow-red-100 dark:shadow-none transition-all active:scale-95 animate-pulse-subtle">
                <span class="material-symbols-outlined text-[20px]">call_end</span>
                <span>Finalizar Reunión</span>
                <span id="reunion-timer" class="font-mono text-xs bg-white/20 px-1.5 py-0.5 rounded-md">00:00</span>
            </button>
            <?php elseif ($citaEnProceso): ?>
            <!-- Botón Finalizar Reunión VISIBLE PERO NO INTERACTUABLE (cita en proceso pero no en horario) -->
            <button disabled
                title="La cita aún no ha comenzado o ya terminó"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border-2 border-amber-200 text-amber-600 font-bold text-sm cursor-not-allowed dark:border-amber-800 dark:text-amber-400">
                <span class="material-symbols-outlined text-[20px]">call_end</span>
                <span>Finalizar Reunión</span>
                <span class="font-mono text-xs bg-amber-100 dark:bg-amber-900/30 px-1.5 py-0.5 rounded-md">Fuera de horario</span>
            </button>
            <?php else: ?>
            <!-- Botón Finalizar Reunión INACTIVO (sin cita en proceso) -->
            <button disabled
                title="No hay ninguna cita en proceso"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-4 py-2.5 rounded-xl border-2 border-slate-200 text-slate-400 font-bold text-sm cursor-not-allowed dark:border-slate-700 dark:text-slate-600">
                <span class="material-symbols-outlined text-[20px]">call_end</span>
                <span>Finalizar Reunión</span>
            </button>
            <?php endif; ?>

            <button onclick="abrirModalDisponibilidad()"
                id="btn-disponibilidad"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 rounded-xl border-2 border-indigo-200 text-indigo-600 font-bold text-sm hover:bg-indigo-50 hover:border-indigo-400 dark:border-indigo-800 dark:text-indigo-400 dark:hover:bg-indigo-900/50 dark:hover:border-indigo-600 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">schedule</span>
                <span class="hidden xs:inline sm:inline">Mi Disponibilidad</span>
                <span class="xs:hidden sm:hidden">Disponibilidad</span>
            </button>
            <button onclick="abrirModalCrearPaciente()"
                id="btn-crear-paciente"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 rounded-xl border-2 border-blue-200 text-blue-600 font-bold text-sm hover:bg-blue-50 hover:border-blue-400 dark:border-blue-800 dark:text-blue-400 dark:hover:bg-blue-900/50 dark:hover:border-blue-600 transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span>Crear Paciente</span>
            </button>
            <button onclick="abrirModalAgendarCita()"
                id="btn-agendar-cita"
                class="flex-1 sm:flex-none flex items-center justify-center gap-2 px-3 sm:px-4 py-2.5 rounded-xl bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold text-sm hover:from-blue-700 hover:to-blue-800 shadow-md shadow-blue-100 dark:shadow-none transition-all active:scale-95">
                <span class="material-symbols-outlined text-[20px]">calendar_add_on</span>
                <span>Agendar Cita</span>
            </button>
        </div>
    </div>

    <!-- ══════════ STATS ROW ══════════ -->
    <div class="grid grid-cols-1 sm:grid-cols-3 gap-5 mb-8">

        <!-- Sesiones este mes -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 rounded-xl">
                    <span class="material-symbols-outlined">clinical_notes</span>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-50 dark:text-slate-400 dark:bg-slate-700 px-2 py-1 rounded-full">Este mes</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Sesiones este mes</p>
            <h3 class="text-3xl font-black text-slate-900 dark:text-slate-100 mt-1"><?= (int)($stats['sesiones_mes'] ?? 0) ?></h3>
        </div>

        <!-- Citas Pendientes -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 rounded-xl">
                    <span class="material-symbols-outlined">pending_actions</span>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-50 dark:text-slate-400 dark:bg-slate-700 px-2 py-1 rounded-full">Próximas</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Citas Pendientes</p>
            <h3 class="text-3xl font-black text-slate-900 dark:text-slate-100 mt-1"><?= (int)($stats['pendientes_hoy'] ?? 0) ?></h3>
        </div>

        <!-- Sesiones Completadas -->
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
            <div class="flex items-center justify-between mb-4">
                <div class="p-3 bg-green-100 text-green-600 dark:bg-green-900/50 dark:text-green-400 rounded-xl">
                    <span class="material-symbols-outlined">task_alt</span>
                </div>
                <span class="text-xs font-bold text-slate-500 bg-slate-50 dark:text-slate-400 dark:bg-slate-700 px-2 py-1 rounded-full">Este mes</span>
            </div>
            <p class="text-slate-500 dark:text-slate-400 text-sm font-medium">Sesiones Completadas</p>
            <h3 class="text-3xl font-black text-slate-900 dark:text-slate-100 mt-1"><?= (int)($stats['altas_medicas'] ?? 0) ?></h3>
        </div>
    </div>

    <!-- ══════════ TABLA DE PACIENTES RECIENTES ══════════ -->
    <div class="bg-white dark:bg-slate-800 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 overflow-hidden mb-8">
        <div class="p-6 border-b border-slate-50 bg-slate-50/30 dark:border-slate-700 dark:bg-slate-800/50 flex flex-col sm:flex-row justify-between items-start sm:items-center gap-4">
            <h2 class="text-lg font-bold text-slate-900 dark:text-slate-100">Citas Recientes de mis Pacientes</h2>
            <div class="flex items-center gap-3 w-full sm:w-auto">
                <select id="filtroCitasRecientes" onchange="ordenarCitasRecientes(this.value)" class="text-sm border-2 border-slate-200 dark:border-slate-600 rounded-xl px-3 py-1.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 focus:outline-none focus:border-blue-400 dark:focus:border-blue-500 transition-colors cursor-pointer">
                    <option value="cercana">Cita más cercana</option>
                    <option value="az">Nombre (A - Z)</option>
                    <option value="za">Nombre (Z - A)</option>
                </select>
                <span class="text-xs text-slate-400 dark:text-slate-500 shrink-0"><?= count($citasRecientes) ?> registros</span>
            </div>
        </div>

        <div class="overflow-x-auto">
            <table class="w-full text-left border-collapse">
                <thead>
                    <tr class="bg-slate-50/50 dark:bg-slate-700/50">
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">#</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Paciente</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Motivo / Estado</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Fecha</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider">Notas</th>
                        <th class="px-5 py-3.5 text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider text-center">Acciones</th>
                    </tr>
                </thead>
                <tbody id="tbody-citas-recientes" class="divide-y divide-slate-100 dark:divide-slate-700">
                    <?php if (empty($citasRecientes)): ?>
                    <tr><td colspan="6" class="px-6 py-10 text-center text-slate-400 dark:text-slate-500 text-sm">No hay citas registradas.</td></tr>
                    <?php else: ?>
                        <?php foreach ($citasRecientes as $i => $cita):
                            $partes   = explode(' ', $cita['paciente_nombre']);
                            $iniciales = count($partes) >= 2
                                ? strtoupper(substr($partes[0],0,1).substr($partes[1],0,1))
                                : strtoupper(substr($cita['paciente_nombre'],0,2));
                            $fechaF  = date('d M Y', strtotime($cita['fecha']));
                            $colores = [
                                'pendiente' => 'bg-blue-100 text-blue-700 dark:bg-blue-900/50 dark:text-blue-400',
                                'completada' => 'bg-green-100 text-green-700 dark:bg-green-900/50 dark:text-green-400',
                                'cancelada' => 'bg-red-100 text-red-700 dark:bg-red-900/50 dark:text-red-400',
                                'en proceso' => 'bg-yellow-100 text-yellow-700 dark:bg-yellow-900/50 dark:text-yellow-400'
                            ];
                            $estadoColor = $colores[$cita['estado']] ?? 'bg-slate-100 text-slate-600 dark:bg-slate-800 dark:text-slate-400';
                        ?>
                        <tr class="cita-row hover:bg-blue-50/20 dark:hover:bg-slate-700/50 transition-colors" data-nombre="<?= htmlspecialchars($cita['paciente_nombre']) ?>" data-fecha="<?= $cita['fecha'] ?> <?= $cita['hora'] ?>">
                            <td class="px-5 py-4 text-sm font-medium text-slate-400 dark:text-slate-500 cita-index"><?= $i + 1 ?></td>
                            <td class="px-5 py-4">
                                <div class="flex items-center gap-3">
                                    <div class="w-8 h-8 rounded-full bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center font-bold text-xs shrink-0">
                                        <?= htmlspecialchars($iniciales) ?>
                                    </div>
                                    <div>
                                        <p class="text-sm font-bold text-slate-900 dark:text-slate-100"><?= htmlspecialchars($cita['paciente_nombre']) ?></p>
                                        <p class="text-xs text-slate-400 dark:text-slate-500"><?= htmlspecialchars($cita['correo_electronico']) ?></p>
                                    </div>
                                </div>
                            </td>
                            <td class="px-5 py-4">
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-bold <?= $estadoColor ?>">
                                    <?= htmlspecialchars(substr($cita['motivo_consulta'] ?? 'Sin motivo', 0, 35)) ?><?= strlen($cita['motivo_consulta'] ?? '') > 35 ? '…' : '' ?>
                                </span>
                            </td>
                            <td class="px-5 py-4 text-sm text-slate-600 dark:text-slate-300"><?= $fechaF ?> <span class="text-slate-400 dark:text-slate-500">· <?= substr($cita['hora'],0,5) ?></span></td>
                            <td class="px-5 py-4 text-sm text-slate-500 dark:text-slate-400 max-w-[200px] truncate">
                                <?php if (!empty($cita['notas_sesion'])): ?>
                                    <?= htmlspecialchars(substr($cita['notas_sesion'], 0, 50) . (strlen($cita['notas_sesion']) > 50 ? '…' : '')) ?>
                                <?php else: ?>
                                    <a href="#notas-pacientes-section" onclick="seleccionarPacienteNotas(<?= $cita['id_usuario'] ?>, '<?= htmlspecialchars(addslashes($cita['paciente_nombre'])) ?>', null)" class="text-purple-600 hover:text-purple-700 dark:text-purple-400 dark:hover:text-purple-300 font-semibold hover:underline inline-flex items-center gap-1 transition-colors">
                                        <span class="material-symbols-outlined text-[16px]">visibility</span> Ver notas
                                    </a>
                                <?php endif; ?>
                            </td>
                            <td class="px-5 py-4 text-center">
                                <button onclick="abrirNotaRapida(<?= $cita['id_usuario'] ?>, '<?= htmlspecialchars(addslashes($cita['paciente_nombre'])) ?>')"
                                    class="p-1.5 rounded-lg text-slate-400 hover:text-blue-600 hover:bg-blue-50 dark:text-slate-500 dark:hover:text-blue-400 dark:hover:bg-blue-900/50 transition-colors" title="Agregar nota">
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
        <div class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700">
            <h3 class="font-bold text-slate-900 dark:text-slate-100 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-blue-500 dark:text-blue-400">event_upcoming</span>
                Citas para Hoy
                <span class="ml-auto text-xs text-slate-400 dark:text-slate-500 font-normal"><?= date('d M Y') ?></span>
            </h3>
            <div class="space-y-3 max-h-[300px] overflow-y-auto pr-1">
                <?php if (empty($citasHoy)): ?>
                    <div class="p-6 text-center text-slate-400 border border-dashed border-slate-200 dark:text-slate-500 dark:border-slate-700 rounded-xl text-sm">
                        🎉 Sin citas pendientes hoy. ¡Día libre!
                    </div>
                <?php else: ?>
                    <?php foreach ($citasHoy as $c):
                        $horaF = date('h:i', strtotime($c['hora']));
                        $amPm  = date('A', strtotime($c['hora']));
                    ?>
                    <div class="flex items-center gap-4 p-3.5 rounded-xl border border-slate-100 hover:border-blue-100 hover:bg-blue-50/20 dark:border-slate-700 dark:hover:border-blue-800 dark:hover:bg-blue-900/20 transition-all">
                        <div class="text-center w-14 shrink-0">
                            <p class="text-xs font-black text-blue-600 dark:text-blue-400 uppercase"><?= $horaF ?></p>
                            <p class="text-[10px] text-slate-400 dark:text-slate-500"><?= $amPm ?></p>
                        </div>
                        <div class="w-[2px] h-8 bg-blue-200 dark:bg-blue-800 shrink-0"></div>
                        <div class="flex-1 min-w-0">
                            <p class="text-sm font-bold text-slate-900 dark:text-slate-100 truncate"><?= htmlspecialchars($c['paciente_nombre']) ?></p>
                            <p class="text-xs text-slate-500 dark:text-slate-400 truncate"><?= htmlspecialchars($c['motivo_consulta'] ?? 'Sin motivo específico') ?></p>
                        </div>
                    </div>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Notas para los Pacientes de Hoy / Buscados -->
        <div id="notas-pacientes-section" class="bg-white dark:bg-slate-800 p-6 rounded-2xl shadow-sm border border-slate-100 dark:border-slate-700 scroll-mt-24">
            <h3 class="font-bold text-slate-900 dark:text-slate-100 mb-5 flex items-center gap-2">
                <span class="material-symbols-outlined text-purple-500 dark:text-purple-400">sticky_note_2</span>
                <span id="titulo-seccion-notas" class="hover:text-purple-600 dark:hover:text-purple-400 transition-colors cursor-pointer">Notas de Pacientes</span>
                <span class="ml-auto text-xs text-slate-400 dark:text-slate-500 font-normal"><?= count($pacientesHoy) ?> paciente(s) hoy</span>
            </h3>

            <?php if (empty($pacientesHoy)): ?>
                <div id="empty-notas-msg" class="p-6 text-center text-slate-400 border border-dashed border-slate-200 dark:text-slate-500 dark:border-slate-700 rounded-xl text-sm mb-4">
                    No hay pacientes programados para hoy.
                </div>
            <?php else: ?>
                <!-- Selector de paciente -->
                <div class="flex gap-2 flex-wrap mb-4">
                    <?php foreach ($pacientesHoy as $idx => $pac): ?>
                    <button onclick="seleccionarPacienteNotas(<?= $pac['id_usuario'] ?>, '<?= htmlspecialchars(addslashes($pac['paciente_nombre'])) ?>', this)"
                        class="paciente-notas-btn text-xs font-semibold px-3 py-1.5 rounded-full border-2 transition-all
                               <?= $idx === 0 ? 'border-purple-500 bg-purple-500 text-white' : 'border-slate-200 text-slate-500 hover:border-purple-300 hover:text-purple-600 dark:border-slate-700 dark:text-slate-400 dark:hover:border-purple-500 dark:hover:text-purple-400' ?>">
                        <?= htmlspecialchars($pac['paciente_nombre']) ?>
                        <?php if ($pac['total_notas'] > 0): ?>
                        <span class="ml-1 text-[10px] opacity-75">(<?= $pac['total_notas'] ?>)</span>
                        <?php endif; ?>
                    </button>
                    <?php endforeach; ?>
                </div>
            <?php endif; ?>

            <!-- Notas del paciente seleccionado -->
            <div id="notasPacienteContainer" class="space-y-2 max-h-[220px] overflow-y-auto pr-1">
                <?php if (!empty($pacientesHoy)): ?>
                <div class="text-center py-6 text-slate-400 dark:text-slate-500 text-sm">
                    <div class="w-6 h-6 border-3 border-purple-200 border-t-purple-400 dark:border-purple-900 dark:border-t-purple-500 rounded-full animate-spin mx-auto mb-2"></div>
                    Cargando notas...
                </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
</div>

<!-- ══════════ MODAL: NOTA RÁPIDA ══════════ -->
<div id="notaRapidaModal" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cerrarNotaRapida()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-md mx-4 z-10 p-7">
        <button onclick="cerrarNotaRapida()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg mb-1">Nueva nota</h3>
        <p id="notaRapidaPacienteNombre" class="text-sm text-purple-500 dark:text-purple-400 font-medium mb-5"></p>
        <input type="hidden" id="notaRapidaIdUsuario">

        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Título</label>
                <input type="text" id="notaRapidaTitulo" placeholder="Ej: Ejercicio de respiración"
                    class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-purple-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Contenido</label>
                <textarea id="notaRapidaContenido" rows="4" placeholder="Escribe la nota o recomendación para el paciente..."
                    class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-purple-400 transition-colors resize-none"></textarea>
            </div>
        </div>

        <div id="notaRapidaError" class="hidden mt-3 p-3 bg-red-50 border border-red-200 text-red-600 dark:bg-red-900/50 dark:border-red-800 dark:text-red-400 rounded-xl text-sm"></div>

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
        b.classList.add('border-slate-200','text-slate-500', 'dark:border-slate-700', 'dark:text-slate-400');
    });
    
    if (btn) {
        btn.classList.add('border-purple-500','bg-purple-500','text-white');
        btn.classList.remove('border-slate-200','text-slate-500', 'dark:border-slate-700', 'dark:text-slate-400');
    }

    const emptyMsg = document.getElementById('empty-notas-msg');
    if (emptyMsg) emptyMsg.classList.add('hidden');

    const tituloSeccion = document.getElementById('titulo-seccion-notas');
    if (tituloSeccion) tituloSeccion.textContent = `Notas de: ${nombre}`;

    const container = document.getElementById('notasPacienteContainer');
    container.innerHTML = `<div class="flex justify-center py-4"><div class="w-6 h-6 border-3 border-purple-200 border-t-purple-400 dark:border-purple-900 dark:border-t-purple-500 rounded-full animate-spin"></div></div>`;

    try {
        const res  = await fetch(BASE + 'panel_psicologas/notasPaciente?id_usuario=' + idUsuario);
        const data = await res.json();
        if (!data.ok) throw new Error(data.error);

        if (!data.notas.length) {
            container.innerHTML = `<p class="text-center text-slate-400 dark:text-slate-500 text-sm py-4">Sin notas para ${esc(nombre)}. <button onclick="abrirNotaRapida(${idUsuario}, '${esc(nombre)}')" class="text-purple-500 dark:text-purple-400 hover:underline font-semibold">+ Agregar</button></p>`;
            return;
        }
        container.innerHTML = data.notas.map(n => `
            <div class="p-3 bg-purple-50 dark:bg-purple-900/20 rounded-xl border border-purple-100 dark:border-purple-800/50">
                <div class="flex items-start justify-between gap-2">
                    <p class="text-sm font-bold text-slate-800 dark:text-slate-200">${esc(n.titulo)}</p>
                    <p class="text-[10px] text-slate-400 dark:text-slate-500 shrink-0">${n.fecha_creacion?.slice(0,10) || ''}</p>
                </div>
                <p class="text-xs text-slate-600 dark:text-slate-400 mt-1 leading-relaxed">${esc(n.contenido)}</p>
            </div>
        `).join('') + `<button onclick="abrirNotaRapida(${idUsuario}, '${esc(nombre)}')" class="w-full mt-2 py-2 text-xs font-semibold text-purple-500 hover:bg-purple-50 border-purple-200 dark:text-purple-400 dark:hover:bg-purple-900/50 dark:border-purple-800/50 rounded-xl border-2 border-dashed transition-colors">+ Nueva nota</button>`;
    } catch(e) {
        container.innerHTML = `<p class="text-red-400 dark:text-red-500 text-sm text-center py-4">Error: ${e.message}</p>`;
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
            
            // Recargar notas del paciente activo instantáneamente
            const nombrePaciente = document.getElementById('notaRapidaPacienteNombre').textContent;
            
            // Intentar encontrar el botón en la lista (si es que existe en "citas de hoy")
            const btnPaciente = document.querySelector(`.paciente-notas-btn[onclick*="${idUsuario}"]`);
            
            // Cargar de nuevo la vista de notas con el ID y nombre actualizados
            seleccionarPacienteNotas(idUsuario, nombrePaciente, btnPaciente);
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

// ─── Ordenar Citas Recientes ─────────────────────────────────────
function ordenarCitasRecientes(criterio) {
    const tbody = document.getElementById('tbody-citas-recientes');
    if (!tbody) return;
    const rows = Array.from(tbody.querySelectorAll('.cita-row'));
    if (rows.length === 0) return;

    rows.sort((a, b) => {
        if (criterio === 'cercana') {
            // Ordenar por fecha y hora (ascendente, las más antiguas o próximas primero)
            return new Date(a.dataset.fecha) - new Date(b.dataset.fecha);
        } else if (criterio === 'az') {
            return a.dataset.nombre.localeCompare(b.dataset.nombre);
        } else if (criterio === 'za') {
            return b.dataset.nombre.localeCompare(a.dataset.nombre);
        }
    });

    // Re-insertar filas en el nuevo orden
    rows.forEach((row, index) => {
        tbody.appendChild(row);
        const indexCell = row.querySelector('.cita-index');
        if (indexCell) indexCell.textContent = index + 1;
    });
}

// Inicializar orden por defecto (más cercana)
window.addEventListener('DOMContentLoaded', () => {
    ordenarCitasRecientes('cercana');
});

window.URL_BASE = '<?= URL_BASE ?>';

// ─── Finalizar Reunión ────────────────────────────────────────
<?php if ($citaEnProceso): ?>
const CITA_EN_PROCESO_ID = <?= (int)$citaEnProceso['id_cita'] ?>;
// Usar hora_inicio_real de la BD si existe, si no, usar hora programada de hoy
const CITA_INICIO_TIMESTAMP = <?= $citaEnProceso['hora_inicio_real'] 
    ? 'new Date("' . $citaEnProceso['fecha'] . ' ' . $citaEnProceso['hora_inicio_real'] . '").getTime()'
    : 'new Date("' . $citaEnProceso['fecha'] . ' ' . $citaEnProceso['hora'] . '").getTime()' ?>;
let reunionTimerInterval = null;

function formatTime(segundos) {
    const m = String(Math.floor(segundos / 60)).padStart(2, '0');
    const s = String(segundos % 60).padStart(2, '0');
    return `${m}:${s}`;
}

// Iniciar timer visible solo si hay hora de inicio real o programada
(function startReunionTimer() {
    const timerEl = document.getElementById('reunion-timer');
    if (!timerEl) return;
    reunionTimerInterval = setInterval(() => {
        const elapsed = Math.floor((Date.now() - CITA_INICIO_TIMESTAMP) / 1000);
        if (elapsed >= 0) {
            timerEl.textContent = formatTime(elapsed);
        } else {
            // Si la cita aún no empezó (hora futura), mostrar 00:00
            timerEl.textContent = '00:00';
        }
    }, 1000);
})();

async function finalizarReunion() {
    const duracionSegundos = Math.floor((Date.now() - CITA_INICIO_TIMESTAMP) / 1000);
    const duracionMinutos  = Math.max(1, Math.round(duracionSegundos / 60));

    if (!confirm(`¿Deseas finalizar la reunión? Duración registrada: ${duracionMinutos} minuto(s).`)) return;

    try {
        const res  = await fetch(BASE + 'chat_bot/terminarCita', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_cita: CITA_EN_PROCESO_ID, duracion_minutos: duracionMinutos, notas_sesion: '' })
        });
        const data = await res.json();

        if (data.ok) {
            clearInterval(reunionTimerInterval);
            // Mostrar modal de resultado
            document.getElementById('reunion-result-minutos').textContent = duracionMinutos;
            const modal = document.getElementById('modalReunionFinalizada');
            modal.classList.remove('hidden');
            modal.classList.add('flex');
        } else {
            alert('Error al finalizar: ' + (data.error || 'Intente nuevamente.'));
        }
    } catch(e) {
        alert('Error de conexión: ' + e.message);
    }
}
<?php else: ?>
function finalizarReunion() {}
<?php endif; ?>
</script>

<?php if ($citaEnProceso): ?>
<!-- Modal: Reunión Finalizada -->
<div id="modalReunionFinalizada" class="fixed inset-0 z-[70] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-sm mx-4 z-10 p-8 text-center">
        <div class="w-20 h-20 rounded-full bg-emerald-100 dark:bg-emerald-900/40 flex items-center justify-center mx-auto mb-5">
            <span class="material-symbols-outlined text-emerald-500 text-[44px]">check_circle</span>
        </div>
        <h3 class="text-xl font-black text-slate-900 dark:text-slate-100 mb-2">¡Reunión finalizada!</h3>
        <p class="text-slate-500 dark:text-slate-400 text-sm mb-2">La sesión ha sido registrada correctamente.</p>
        <div class="bg-slate-50 dark:bg-slate-900 rounded-2xl py-4 px-6 mb-6">
            <p class="text-4xl font-black text-emerald-600 dark:text-emerald-400" id="reunion-result-minutos">0</p>
            <p class="text-xs text-slate-500 dark:text-slate-400 mt-1 font-medium">minuto(s) de sesión</p>
        </div>
        <button onclick="location.reload()" class="w-full py-3 bg-gradient-to-r from-emerald-500 to-green-600 text-white font-bold rounded-xl hover:from-emerald-600 hover:to-green-700 transition-all active:scale-[0.98] shadow-md">
            Volver al panel
        </button>
    </div>
</div>
<?php endif; ?>

<!-- ══════════ MODAL: AGENDAR CITA ══════════ -->
<div id="modalAgendarCita" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalAgendarCita()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-lg mx-4 z-10 p-7 max-h-[92vh] overflow-y-auto">
        <button onclick="cerrarModalAgendarCita()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-2xl">
                <span class="material-symbols-outlined text-blue-600 dark:text-blue-400 text-2xl">calendar_add_on</span>
            </div>
            <div>
                <h3 class="font-black text-slate-800 dark:text-slate-100 text-xl">Agendar Cita</h3>
                <p class="text-sm text-slate-400 dark:text-slate-500">Programa una sesión para un paciente</p>
            </div>
        </div>

        <!-- Buscador de paciente -->
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Paciente <span class="text-red-400">*</span></label>
                <div class="relative">
                    <input type="text" id="agendarBuscadorInput" placeholder="Buscar por nombre o correo..."
                        autocomplete="off"
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors pr-10">
                    <span class="material-symbols-outlined absolute right-3 top-1/2 -translate-y-1/2 text-slate-300 dark:text-slate-500 text-[20px]">search</span>
                </div>
                <div id="agendarResultadosPacientes" class="hidden mt-1 bg-white dark:bg-slate-800 border border-slate-200 dark:border-slate-700 rounded-xl shadow-lg overflow-hidden max-h-48 overflow-y-auto z-20 relative"></div>
                <input type="hidden" id="agendarIdUsuario">
                <p id="agendarPacienteSeleccionado" class="hidden mt-2 text-xs font-semibold text-blue-600 dark:text-blue-400 flex items-center gap-1">
                    <span class="material-symbols-outlined text-[16px]">check_circle</span>
                    <span id="agendarPacienteNombre"></span>
                </p>
            </div>

            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Fecha <span class="text-red-400">*</span></label>
                    <input type="date" id="agendarFecha" min="<?= date('Y-m-d') ?>"
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Hora <span class="text-red-400">*</span></label>
                    <select id="agendarHora" disabled
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors disabled:opacity-50 disabled:cursor-not-allowed">
                        <option value="">Elige una fecha primero</option>
                    </select>
                </div>
            </div>

            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Motivo de Consulta</label>
                <textarea id="agendarMotivo" rows="3" placeholder="Describe el motivo principal de la sesión..."
                    class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors resize-none"></textarea>
            </div>
        </div>

        <div id="agendarError" class="hidden mt-4 p-3 bg-red-50 border border-red-200 text-red-600 dark:bg-red-900/50 dark:border-red-800 dark:text-red-400 rounded-xl text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
            <span id="agendarErrorMsg"></span>
        </div>
        <div id="agendarSuccess" class="hidden mt-4 p-3 bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/50 dark:border-green-800 dark:text-green-400 rounded-xl text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">check_circle</span>
            <span id="agendarSuccessMsg"></span>
        </div>

        <button onclick="guardarCitaAgendada()" id="btnGuardarCita"
            class="w-full mt-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all active:scale-[0.98] shadow-md shadow-blue-100 flex items-center justify-center gap-2">
            <span class="material-symbols-outlined text-[20px]">event_available</span>
            Confirmar Cita
        </button>
    </div>
</div>

<!-- ══════════ MODAL: CREAR PACIENTE ══════════ -->
<div id="modalCrearPaciente" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/50 backdrop-blur-sm" onclick="cerrarModalCrearPaciente()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-xl mx-4 z-10 p-7 max-h-[92vh] overflow-y-auto">
        <button onclick="cerrarModalCrearPaciente()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-blue-100 dark:bg-blue-900/50 rounded-2xl">
                <span class="material-symbols-outlined text-blue-500 dark:text-blue-400 text-2xl">person_add</span>
            </div>
            <div>
                <h3 class="font-black text-slate-800 dark:text-slate-100 text-xl">Nuevo Paciente</h3>
                <p class="text-sm text-slate-400 dark:text-slate-500">Registrar paciente desde el panel</p>
            </div>
        </div>

        <div class="space-y-4">
            <!-- Datos básicos -->
            <p class="text-xs font-bold text-slate-400 border-slate-100 dark:text-slate-500 dark:border-slate-700 uppercase tracking-wider border-b pb-2">Datos del Paciente</p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Grado <span class="text-red-400">*</span></label>
                    <select id="cpGrado" class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                        <option value="">Seleccionar</option>
                        <?php foreach(['6','7','8','9','10','11'] as $g): ?>
                        <option value="<?= $g ?>">Grado <?= $g ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nombre Completo <span class="text-red-400">*</span></label>
                    <input type="text" id="cpNombre" placeholder="Nombre del paciente"
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
            <div>
                <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Correo Electrónico <span class="text-red-400">*</span></label>
                <input type="email" id="cpCorreo" placeholder="correo@ejemplo.com"
                    class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Contraseña <span class="text-red-400">*</span></label>
                    <input type="password" id="cpContrasena" placeholder="Contraseña inicial"
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Confirmar Contraseña <span class="text-red-400">*</span></label>
                    <input type="password" id="cpContrasena2" placeholder="Repetir contraseña"
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>

            <!-- Datos acudiente -->
            <p class="text-xs font-bold text-slate-400 border-slate-100 dark:text-slate-500 dark:border-slate-700 uppercase tracking-wider border-b pb-2 mt-2">Datos del Acudiente <span class="font-normal text-slate-300">(opcional)</span></p>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nombre Acudiente</label>
                    <input type="text" id="cpAcudNombre" placeholder="Nombre completo"
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Cédula</label>
                    <input type="text" id="cpAcudCedula" placeholder="Solo números"
                        inputmode="numeric" pattern="[0-9]*"
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
            <div class="grid grid-cols-2 gap-3">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Relación</label>
                    <select id="cpAcudRelacion" class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
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
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Correo Acudiente</label>
                    <input type="email" id="cpAcudCorreo" placeholder="correo@ejemplo.com"
                        class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                </div>
            </div>
        </div>

        <div id="cpError" class="hidden mt-4 p-3 bg-red-50 border border-red-200 text-red-600 dark:bg-red-900/50 dark:border-red-800 dark:text-red-400 rounded-xl text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">error</span>
            <span id="cpErrorMsg"></span>
        </div>
        <div id="cpSuccess" class="hidden mt-4 p-3 bg-green-50 border border-green-200 text-green-700 dark:bg-green-900/50 dark:border-green-800 dark:text-green-400 rounded-xl text-sm flex items-center gap-2">
            <span class="material-symbols-outlined text-[18px] shrink-0">check_circle</span>
            <span id="cpSuccessMsg"></span>
        </div>

        <button onclick="guardarNuevoPaciente()" id="btnGuardarPaciente"
            class="w-full mt-5 py-3 bg-gradient-to-r from-blue-500 to-indigo-600 text-white font-bold rounded-xl hover:from-blue-600 hover:to-indigo-700 transition-all active:scale-[0.98] shadow-md shadow-blue-200 dark:shadow-none flex items-center justify-center gap-2">
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
                    class="w-full text-left px-4 py-2.5 hover:bg-blue-50 transition-colors border-b border-slate-100 last:border-0">
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
                <div class="p-6 text-center text-slate-400 dark:text-slate-500 border border-dashed border-slate-200 dark:border-slate-700 rounded-xl text-sm">
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
                    <div class="border border-slate-100 dark:border-slate-700 rounded-2xl p-4 bg-slate-50/50 dark:bg-slate-700/30">
                        <h5 class="font-bold text-slate-800 dark:text-slate-200 text-sm mb-3 flex items-center gap-1.5">
                            <span class="w-2 h-2 rounded-full bg-indigo-500"></span>
                            ${esc(dia)}
                        </h5>
                        <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                            ${bloques.map(b => {
                                const jornadaDisplay = b.jornada 
                                    ? esc(b.jornada) 
                                    : (esc(b.hora_inicio) + ' - ' + esc(b.hora_fin));
                                return `
                                <div class="flex items-center justify-between bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-xl px-3 py-2 text-sm shadow-sm hover:border-slate-200 dark:hover:border-slate-600 transition-colors">
                                    <span class="font-semibold text-slate-600 dark:text-slate-300">${jornadaDisplay}</span>
                                    <button onclick="eliminarHorario(${b.id_disponibilidad})" class="p-1 rounded-lg text-slate-400 dark:text-slate-500 hover:text-red-500 dark:hover:text-red-400 hover:bg-red-50 dark:hover:bg-red-900/30 transition-all active:scale-90" title="Eliminar jornada">
                                        <span class="material-symbols-outlined text-[18px]">delete</span>
                                    </button>
                                </div>
                            `;
                            }).join('')}
                        </div>
                    </div>`;
            }
        });
        container.innerHTML = html || `
            <div class="p-6 text-center text-slate-400 dark:text-slate-500 border border-dashed border-slate-200 dark:border-slate-700 rounded-xl text-sm">
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
    const jornada = document.getElementById('dispJornada').value;

    if (!dia || !jornada) {
        errorMsg.textContent = 'Selecciona el día y la jornada.';
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
            body: JSON.stringify({ dia_semana: dia, jornada: jornada })
        });
        const data = await res.json();
        if (data.ok) {
            cargarDisponibilidad();
            document.getElementById('dispJornada').value = '';
        } else {
            errorMsg.textContent = data.error;
            errorCont.classList.remove('hidden');
        }
    } catch(e) {
        errorMsg.textContent = 'Error de conexión.';
        errorCont.classList.remove('hidden');
    }
    btn.disabled = false;
    btn.innerHTML = '<span class="material-symbols-outlined text-[18px]">add_circle</span> Agregar jornada';
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
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-2xl mx-4 z-10 p-7 max-h-[92vh] overflow-y-auto">
        <button onclick="cerrarModalDisponibilidad()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <div class="flex items-center gap-3 mb-6">
            <div class="p-3 bg-indigo-100 dark:bg-indigo-900/50 rounded-2xl">
                <span class="material-symbols-outlined text-indigo-600 dark:text-indigo-400 text-2xl">schedule</span>
            </div>
            <div>
                <h3 class="font-black text-slate-800 dark:text-slate-100 text-xl">Mi Disponibilidad</h3>
                <p class="text-sm text-slate-400 dark:text-slate-500">Configura tus bloques de horarios semanales</p>
            </div>
        </div>

        <!-- Agregar nuevo horario -->
        <div class="bg-indigo-50/50 dark:bg-indigo-900/20 border border-indigo-100 dark:border-indigo-800/50 rounded-2xl p-4 mb-6">
            <h4 class="text-xs font-bold text-indigo-800 dark:text-indigo-300 uppercase tracking-wider mb-3">Agregar Jornada</h4>
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-3 items-end">
                <div>
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Día de la Semana</label>
                    <select id="dispDia" class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-3 py-2 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-indigo-400 transition-colors">
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
                    <label class="block text-xs font-bold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Jornada (solo 1 por día)</label>
                    <select id="dispJornada" class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-3 py-2 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-indigo-400 transition-colors">
                        <option value="">Seleccionar jornada</option>
                        <option value="07:00-13:00">07:00 - 13:00 (Mañana)</option>
                        <option value="08:00-14:00">08:00 - 14:00 (Mañana)</option>
                        <option value="09:00-15:00">09:00 - 15:00 (Mañana-Tarde)</option>
                        <option value="10:00-16:00">10:00 - 16:00 (Mediodía)</option>
                        <option value="13:00-19:00">13:00 - 19:00 (Tarde)</option>
                        <option value="14:00-20:00">14:00 - 20:00 (Tarde)</option>
                        <option value="15:00-21:00">15:00 - 21:00 (Tarde-Noche)</option>
                    </select>
                </div>
            </div>
            
            <div id="dispFormError" class="hidden mt-3 p-2.5 bg-red-50 border border-red-200 text-red-600 dark:bg-red-900/50 dark:border-red-800 dark:text-red-400 rounded-xl text-xs flex items-center gap-2">
                <span class="material-symbols-outlined text-[16px] shrink-0">error</span>
                <span id="dispFormErrorMsg"></span>
            </div>

            <button onclick="agregarHorarioDisponibilidad()" id="btnAgregarDisp"
                class="w-full mt-4 py-2.5 bg-indigo-600 text-white font-bold rounded-xl hover:bg-indigo-700 transition-all active:scale-[0.98] flex items-center justify-center gap-2 text-sm">
                <span class="material-symbols-outlined text-[18px]">add_circle</span>
                Agregar jornada
            </button>
        </div>

        <!-- Lista de disponibilidad agrupada por días -->
        <div>
            <h4 class="text-xs font-bold text-slate-400 dark:text-slate-500 uppercase tracking-wider border-b border-slate-100 dark:border-slate-700 pb-2 mb-3">Mis Horarios Activos</h4>
            <div id="dispListaContainer" class="space-y-4 max-h-[40vh] overflow-y-auto pr-1">
                <!-- Se llena vía JS -->
            </div>
        </div>
    </div>
</div>

