<?php
/**
 * Vista: Mis Citas (paciente)
 * Variables: $citas[], $psicologos[]
 */
?>
<div class="p-6 md:p-8 max-w-5xl mx-auto w-full">

    <!-- Encabezado -->
    <div class="mb-8 flex items-center justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-900 dark:text-slate-100">Mis Citas</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-1">Gestiona y edita tus citas programadas</p>
        </div>
        <button onclick="openChatbotModal()"
            class="flex items-center gap-2 px-5 py-2.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all active:scale-[0.97] shadow-md shadow-blue-100 text-sm">
            <span class="material-symbols-outlined text-[18px]">add</span>
            Nueva Cita
        </button>
    </div>

    <!-- Tabs de estado -->
    <div class="flex gap-2 mb-6 overflow-x-auto pb-1" id="citasTabs">
        <?php
        $tabs = [
            'todas'     => ['label' => 'Todas', 'icon' => 'list'],
            'pendiente' => ['label' => 'Pendientes', 'icon' => 'schedule'],
            'completada'=> ['label' => 'Completadas', 'icon' => 'check_circle'],
            'cancelada' => ['label' => 'Canceladas', 'icon' => 'cancel'],
        ];
        foreach ($tabs as $key => $tab): ?>
            <button onclick="filtrarCitas('<?= $key ?>')" id="tab-<?= $key ?>"
                class="tab-btn flex items-center gap-1.5 px-4 py-2 rounded-full text-sm font-semibold whitespace-nowrap transition-all border-2 <?= $key === 'todas' ? 'border-blue-500 bg-blue-500 text-white' : 'border-slate-200 text-slate-500 hover:border-blue-200 hover:text-blue-600 dark:border-slate-700 dark:text-slate-400 dark:hover:border-blue-500 dark:hover:text-blue-400' ?>">
                <span class="material-symbols-outlined text-[16px]"><?= $tab['icon'] ?></span>
                <?= $tab['label'] ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Lista de citas -->
    <?php if (empty($citas)): ?>
        <div class="text-center py-20">
            <span class="material-symbols-outlined text-[64px] text-slate-200 dark:text-slate-700 block mb-4">event_busy</span>
            <h3 class="text-lg font-bold text-slate-600 dark:text-slate-300 mb-2">Sin citas registradas</h3>
            <p class="text-slate-400 dark:text-slate-500 text-sm mb-6">Agenda tu primera cita con una de nuestras psicólogas.</p>
            <button onclick="openChatbotModal()"
                class="px-6 py-3 bg-blue-600 text-white font-bold rounded-xl hover:bg-blue-700 transition-colors">
                Agendar ahora
            </button>
        </div>
    <?php else: ?>
        <div id="citasContainer" class="space-y-4">
            <?php foreach ($citas as $cita):
                $fechaF  = date('d M Y', strtotime($cita['fecha']));
                $horaF   = date('h:i A', strtotime($cita['hora']));
                $esPasada= $cita['fecha'] < date('Y-m-d');
                $estadoStyle = match($cita['estado']) {
                    'pendiente'  => 'bg-blue-100 text-blue-700 border-blue-200 dark:bg-blue-900/50 dark:text-blue-400 dark:border-blue-800',
                    'completada' => 'bg-green-100 text-green-700 border-green-200 dark:bg-green-900/50 dark:text-green-400 dark:border-green-800',
                    'cancelada'  => 'bg-red-100 text-red-700 border-red-200 dark:bg-red-900/50 dark:text-red-400 dark:border-red-800',
                    'en proceso' => 'bg-yellow-100 text-yellow-700 border-yellow-200 dark:bg-yellow-900/50 dark:text-yellow-400 dark:border-yellow-800',
                    default      => 'bg-slate-100 text-slate-600 border-slate-200 dark:bg-slate-800 dark:text-slate-400 dark:border-slate-700',
                };
            ?>
            <div class="cita-card group bg-white border-2 border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl p-5 hover:border-blue-200 dark:hover:border-blue-500 hover:shadow-md transition-all"
                 data-estado="<?= $cita['estado'] ?>">
                <div class="flex items-start gap-4 flex-wrap">

                    <!-- Avatar psicólogo -->
                    <img src="<?= htmlspecialchars($cita['foto_perfil']) ?>" alt="<?= htmlspecialchars($cita['psicologo_nombre']) ?>"
                        class="w-12 h-12 rounded-xl object-cover shrink-0 ring-2 ring-blue-100 dark:ring-slate-700 group-hover:ring-blue-300 dark:group-hover:ring-blue-500 transition-all">

                    <!-- Info principal -->
                    <div class="flex-1 min-w-0">
                        <div class="flex items-center gap-2 flex-wrap mb-1">
                            <p class="font-bold text-slate-900 dark:text-slate-100 text-base"><?= htmlspecialchars($cita['psicologo_nombre']) ?></p>
                            <span class="text-xs px-2.5 py-0.5 rounded-full border font-semibold <?= $estadoStyle ?>">
                                <?= ucfirst($cita['estado']) ?>
                            </span>
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mb-2"><?= htmlspecialchars($cita['especialidad']) ?></p>
                        <div class="flex items-center gap-4 text-sm text-slate-600 dark:text-slate-300">
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-blue-500 dark:text-blue-400">calendar_month</span>
                                <?= $fechaF ?>
                            </span>
                            <span class="flex items-center gap-1">
                                <span class="material-symbols-outlined text-[16px] text-blue-500 dark:text-blue-400">schedule</span>
                                <?= $horaF ?>
                            </span>
                        </div>
                        <?php if (!empty($cita['motivo_consulta'])): ?>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-2 truncate max-w-sm">
                            <span class="material-symbols-outlined text-[13px] align-middle mr-1">notes</span>
                            <?= htmlspecialchars($cita['motivo_consulta']) ?>
                        </p>
                        <?php endif; ?>
                    </div>

                    <!-- Acciones -->
                    <?php if ($cita['estado'] === 'pendiente' && !$esPasada): ?>
                    <div class="flex gap-2 shrink-0 self-start">
                        <button onclick="abrirModalEditar(<?= $cita['id_cita'] ?>, '<?= $cita['fecha'] ?>', '<?= substr($cita['hora'],0,5) ?>', <?= $cita['id_psicologo'] ?>, '<?= htmlspecialchars(addslashes($cita['psicologo_nombre'])) ?>')"
                            class="flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-slate-600 bg-slate-100 dark:text-slate-300 dark:bg-slate-700 hover:bg-blue-50 hover:text-blue-600 dark:hover:bg-blue-900/50 dark:hover:text-blue-400 rounded-xl transition-all">
                            <span class="material-symbols-outlined text-[16px]">edit</span>
                            Editar
                        </button>
                        <button onclick="cancelarCita(<?= $cita['id_cita'] ?>)"
                            class="flex items-center gap-1.5 px-3 py-2 text-xs font-bold text-red-500 bg-red-50 dark:text-red-400 dark:bg-red-900/50 hover:bg-red-100 dark:hover:bg-red-900 rounded-xl transition-all">
                            <span class="material-symbols-outlined text-[16px]">cancel</span>
                            Cancelar
                        </button>
                    </div>
                    <?php endif; ?>
                </div>
            </div>
            <?php endforeach; ?>
        </div>
    <?php endif; ?>
</div>

<!-- ══════════ MODAL EDITAR CITA ══════════ -->
<div id="editarCitaModal" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cerrarModalEditar()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl w-full max-w-md mx-4 z-10 p-7">
        <button onclick="cerrarModalEditar()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 dark:hover:bg-slate-700 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>

        <div class="flex items-center gap-3 mb-6">
            <div class="w-10 h-10 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center">
                <span class="material-symbols-outlined">edit_calendar</span>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Editar Cita</h3>
                <p id="editarPsicologoLabel" class="text-xs text-blue-500"></p>
            </div>
        </div>

        <input type="hidden" id="editarIdCita">

        <div class="space-y-4">
            <!-- Nueva Fecha -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nueva Fecha</label>
                <input type="date" id="editarFecha" min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                    onchange="cargarHorasEditar()"
                    class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>

            <!-- Psicólogo -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Psicólogo/a</label>
                <select id="editarPsicologo" onchange="cargarHorasEditar()"
                    class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                    <?php foreach ($psicologos as $p): ?>
                    <option value="<?= $p['id_psicologo'] ?>"><?= htmlspecialchars($p['nombre']) ?> — <?= htmlspecialchars($p['especialidad']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>

            <!-- Hora -->
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Hora disponible</label>
                <div id="editarHorasGrid" class="grid grid-cols-4 gap-2 min-h-[48px]">
                    <p class="col-span-4 text-xs text-slate-400 dark:text-slate-500 text-center py-2">Selecciona fecha y psicólogo primero</p>
                </div>
                <input type="hidden" id="editarHoraSeleccionada">
            </div>
        </div>

        <div id="editarError" class="hidden mt-3 p-3 bg-red-50 border border-red-200 text-red-600 dark:bg-red-900/50 dark:border-red-800 dark:text-red-400 rounded-xl text-sm"></div>

        <button onclick="guardarEdicion()" id="editarBtnGuardar" disabled
            class="w-full mt-5 py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-bold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed">
            Guardar cambios
        </button>
    </div>
</div>

<!-- ══════════ TOAST DE NOTIFICACIÓN ══════════ -->
<div id="citasToast" class="fixed bottom-6 right-6 z-[80] hidden">
    <div id="citasToastInner" class="flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-semibold text-white min-w-[260px]">
        <span class="material-symbols-outlined text-[20px]" id="citasToastIcon">check_circle</span>
        <span id="citasToastMsg"></span>
    </div>
</div>

<script>
const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');

// ─── Filtrar citas por tab ───────────────────────────────────────
function filtrarCitas(estado) {
    document.querySelectorAll('.tab-btn').forEach(b => {
        b.classList.remove('border-blue-500','bg-blue-500','text-white');
        b.classList.add('border-slate-200','text-slate-500', 'dark:border-slate-700', 'dark:text-slate-400');
    });
    const activeBtn = document.getElementById('tab-' + estado);
    if (activeBtn) {
        activeBtn.classList.add('border-blue-500','bg-blue-500','text-white');
        activeBtn.classList.remove('border-slate-200','text-slate-500', 'dark:border-slate-700', 'dark:text-slate-400');
    }
    document.querySelectorAll('.cita-card').forEach(card => {
        const cardEstado = card.dataset.estado;
        const show = estado === 'todas' || cardEstado === estado;
        card.style.display = show ? '' : 'none';
    });
}

// ─── Cancelar Cita ───────────────────────────────────────────────
async function cancelarCita(idCita) {
    if (!confirm('¿Seguro que quieres cancelar esta cita? Esta acción no se puede deshacer.')) return;
    try {
        const res  = await fetch(BASE + 'citas/cancelar', {
            method: 'POST', headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ id_cita: idCita })
        });
        const data = await res.json();
        if (data.ok) {
            mostrarToast(data.mensaje, 'success');
            setTimeout(() => location.reload(), 1200);
        } else {
            mostrarToast(data.error, 'error');
        }
    } catch(e) {
        mostrarToast('Error de conexión.', 'error');
    }
}

// ─── Modal Editar ────────────────────────────────────────────────
function abrirModalEditar(idCita, fecha, hora, idPsicologo, nombrePsicologo) {
    document.getElementById('editarIdCita').value      = idCita;
    document.getElementById('editarFecha').value       = fecha;
    document.getElementById('editarPsicologo').value   = idPsicologo;
    document.getElementById('editarPsicologoLabel').textContent = nombrePsicologo;
    document.getElementById('editarHoraSeleccionada').value = hora;
    document.getElementById('editarBtnGuardar').disabled = false;
    document.getElementById('editarError').classList.add('hidden');

    // Pre-seleccionar hora actual en el grid
    cargarHorasEditar(hora);

    document.getElementById('editarCitaModal').classList.remove('hidden');
    document.getElementById('editarCitaModal').classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function cerrarModalEditar() {
    document.getElementById('editarCitaModal').classList.add('hidden');
    document.getElementById('editarCitaModal').classList.remove('flex');
    document.body.style.overflow = '';
}

async function cargarHorasEditar(horaPreseleccionada = null) {
    const fecha      = document.getElementById('editarFecha').value;
    const idPsicologo = document.getElementById('editarPsicologo').value;
    const grid       = document.getElementById('editarHorasGrid');
    if (!fecha || !idPsicologo) return;

    grid.innerHTML = `<div class="col-span-4 flex justify-center py-2"><div class="w-6 h-6 border-3 border-blue-200 border-t-blue-500 rounded-full animate-spin"></div></div>`;
    document.getElementById('editarHoraSeleccionada').value = '';
    document.getElementById('editarBtnGuardar').disabled = true;

    try {
        const idCita = document.getElementById('editarIdCita').value;
        const res  = await fetch(`${BASE}citas/horasDisponiblesEdicion?fecha=${fecha}&id_psicologo=${idPsicologo}&id_cita=${idCita}`);
        const data = await res.json();
        if (!data.ok || !data.horas.length) {
            grid.innerHTML = `<p class="col-span-4 text-xs text-slate-400 dark:text-slate-500 text-center py-2">Sin horas disponibles este día.</p>`;
            return;
        }
        grid.innerHTML = data.horas.map(h => `
            <button onclick="seleccionarHoraEditar('${h}', this)"
                class="hora-edit-btn py-2 text-xs font-semibold border-2 border-slate-200 dark:border-slate-700 rounded-xl hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50 dark:hover:bg-blue-900/50 dark:hover:text-blue-400 transition-all ${h === horaPreseleccionada ? 'border-blue-500 bg-blue-500 text-white' : 'text-slate-600 dark:text-slate-300'}">
                ${h}
            </button>
        `).join('');
        if (horaPreseleccionada && data.horas.includes(horaPreseleccionada)) {
            document.getElementById('editarHoraSeleccionada').value = horaPreseleccionada;
            document.getElementById('editarBtnGuardar').disabled = false;
        }
    } catch(e) {
        grid.innerHTML = `<p class="col-span-4 text-xs text-red-400 text-center py-2">Error al cargar horas.</p>`;
    }
}

function seleccionarHoraEditar(hora, btn) {
    document.querySelectorAll('.hora-edit-btn').forEach(b => {
        b.classList.remove('border-blue-500','bg-blue-500','text-white');
        b.classList.add('border-slate-200','text-slate-600', 'dark:border-slate-700', 'dark:text-slate-300');
    });
    btn.classList.add('border-blue-500','bg-blue-500','text-white');
    btn.classList.remove('border-slate-200','text-slate-600', 'dark:border-slate-700', 'dark:text-slate-300');
    document.getElementById('editarHoraSeleccionada').value = hora;
    document.getElementById('editarBtnGuardar').disabled = false;
}

async function guardarEdicion() {
    const idCita      = document.getElementById('editarIdCita').value;
    const fecha       = document.getElementById('editarFecha').value;
    const hora        = document.getElementById('editarHoraSeleccionada').value;
    const idPsicologo = document.getElementById('editarPsicologo').value;
    const errEl       = document.getElementById('editarError');

    if (!hora) { errEl.textContent = 'Selecciona una hora.'; errEl.classList.remove('hidden'); return; }
    errEl.classList.add('hidden');

    try {
        const res  = await fetch(BASE + 'citas/editar', {
            method: 'POST', headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ id_cita: parseInt(idCita), fecha, hora, id_psicologo: parseInt(idPsicologo) })
        });
        const data = await res.json();
        if (data.ok) {
            cerrarModalEditar();
            mostrarToast('¡Cita actualizada correctamente!', 'success');
            setTimeout(() => location.reload(), 1200);
        } else {
            errEl.textContent = data.error;
            errEl.classList.remove('hidden');
        }
    } catch(e) {
        errEl.textContent = 'Error de conexión.';
        errEl.classList.remove('hidden');
    }
}

// ─── Toast ───────────────────────────────────────────────────────
function mostrarToast(msg, tipo = 'success') {
    const toast = document.getElementById('citasToast');
    const inner = document.getElementById('citasToastInner');
    const icon  = document.getElementById('citasToastIcon');
    const msgEl = document.getElementById('citasToastMsg');
    msgEl.textContent = msg;
    icon.textContent  = tipo === 'success' ? 'check_circle' : 'error';
    inner.className = `flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-semibold text-white min-w-[260px] ${tipo === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3000);
}

window.URL_BASE = '<?= URL_BASE ?>';
</script>
