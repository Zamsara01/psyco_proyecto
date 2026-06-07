<?php
/**
 * Vista: Panel Psicólogas
 * Variables: $stats[], $citasRecientes[], $citasHoy[], $pacientesHoy[]
 */
?>
<div class="p-6 md:p-8 flex-1">

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
