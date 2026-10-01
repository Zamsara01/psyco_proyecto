<?php
/**
 * Vista: Mis Citas (paciente) — Nueva UI
 * Variables: $citas[], $psicologos[]
 */
?>
<style>
    /* Fondo de página */
    #main-content {
        background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpeg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
    }
    #main-content::before {
        content: '';
        position: fixed;
        inset: 0;
        background: rgba(244, 247, 246, 0.55);
        pointer-events: none;
        z-index: 0;
    }
    .dark #main-content::before { background: rgba(15, 23, 42, 0.65); }

    /* Tarjetas */
    .cita-card {
        background: rgba(255,255,255,0.88) !important;
        backdrop-filter: blur(6px);
        transition: box-shadow .2s, transform .2s;
    }
    .dark .cita-card { background: rgba(30, 41, 59, 0.88) !important; }
    .cita-card:hover { box-shadow: 0 8px 28px rgba(0,0,0,0.10) !important; transform: translateY(-1px); }

    /* Avatar circular con iniciales */
    .cita-avatar {
        width: 44px; height: 44px;
        border-radius: 50%;
        display: flex; align-items: center; justify-content: center;
        font-weight: 800; font-size: 1rem;
        flex-shrink: 0; color: white;
        background: linear-gradient(135deg, #E8824A, #D96B30);
        box-shadow: 0 2px 8px rgba(232,130,74,0.35);
    }

    /* Tabs de filtro */
    .tab-btn {
        border-radius: 999px !important;
        font-size: 0.82rem !important;
        padding: 0.45rem 1.1rem !important;
        display: flex; align-items: center; gap: 5px;
        border-width: 1.5px !important;
        transition: all .18s;
    }
    .tab-btn.active {
        background: #8DA399 !important;
        border-color: #8DA399 !important;
        color: white !important;
    }
    .tab-btn:not(.active) {
        background: rgba(255,255,255,0.7) !important;
        border-color: #c5d4cd !important;
        color: #4a6e66 !important;
    }
    .tab-btn:not(.active):hover { border-color: #8DA399 !important; color: #3a5a50 !important; }

    /* Botones de acción */
    .btn-editar {
        display: flex; align-items: center; gap: 5px;
        padding: 0.42rem 0.9rem; border-radius: 0.65rem;
        font-size: 0.78rem; font-weight: 700;
        background: rgba(107,140,174,0.15); color: #4a6e8a;
        border: 1.5px solid rgba(107,140,174,0.35); transition: all .18s;
    }
    .btn-editar:hover { background: rgba(107,140,174,0.28); }

    .btn-cancelar {
        display: flex; align-items: center; gap: 5px;
        padding: 0.42rem 0.9rem; border-radius: 0.65rem;
        font-size: 0.78rem; font-weight: 700;
        background: rgba(174,107,107,0.12); color: #8a4a4a;
        border: 1.5px solid rgba(174,107,107,0.3); transition: all .18s;
    }
    .btn-cancelar:hover { background: rgba(174,107,107,0.24); }

    /* Badges de estado — alineados con la paleta de la UI */
    .badge { font-size:0.72rem; padding:2px 9px; border-radius:999px; font-weight:700; }
    /* Pendiente → Azul pizarra suave (#6B8CAE) */
    .badge-pendiente  { background:#dce8f0; color:#3a6a8a; border:1px solid #b5cfe0; }
    /* Completada → Verde salvia suave (#8DA399) */
    .badge-completada { background:#d8e8e2; color:#3d6b5a; border:1px solid #b0d0c4; }
    /* Cancelada → Arcilla/Terracota suave (tono del avatar naranja) */
    .badge-cancelada  { background:#f5e0d4; color:#a0503a; border:1px solid #e8c0a8; }
    /* En proceso → Arena cálida */
    .badge-en-proceso { background:#f0e8d8; color:#8a6a38; border:1px solid #ddd0b0; }
</style>

<div class="relative z-10 p-6 md:p-8 max-w-4xl mx-auto w-full">

    <!-- Encabezado -->
    <div class="mb-6 flex items-start justify-between flex-wrap gap-4">
        <div>
            <h1 class="text-2xl font-black text-slate-800 dark:text-slate-100">Mis Citas</h1>
            <p class="text-slate-500 dark:text-slate-400 text-sm mt-0.5">Gestione y edite sus citas programadas</p>
        </div>
        <button onclick="openChatbotModal()"
            class="flex items-center gap-2 px-5 py-2.5 rounded-xl font-bold text-sm text-white shadow-md transition-all hover:scale-105 active:scale-95"
            style="background: linear-gradient(135deg,#6B8CAE,#5a7e9f);">
            <span class="material-symbols-outlined text-[17px]">add</span>
            Nueva Cita
        </button>
    </div>

    <!-- Tabs de estado -->
    <div class="flex gap-2 mb-6 overflow-x-auto pb-1 flex-wrap" id="citasTabs">
        <?php
        $tabs = [
            'todas'      => ['label' => 'Todas',       'icon' => 'format_list_bulleted'],
            'pendiente'  => ['label' => 'Pendientes',  'icon' => 'schedule'],
            'completada' => ['label' => 'Completadas', 'icon' => 'check_circle'],
            'cancelada'  => ['label' => 'Canceladas',  'icon' => 'cancel'],
        ];
        foreach ($tabs as $key => $tab): ?>
            <button onclick="filtrarCitas('<?= $key ?>')" id="tab-<?= $key ?>"
                class="tab-btn <?= $key === 'todas' ? 'active' : '' ?>">
                <span class="material-symbols-outlined" style="font-size:15px;"><?= $tab['icon'] ?></span>
                <?= $tab['label'] ?>
            </button>
        <?php endforeach; ?>
    </div>

    <!-- Lista de citas -->
    <?php if (empty($citas)): ?>
        <div class="text-center py-20 cita-card rounded-2xl">
            <span class="material-symbols-outlined text-[64px] text-slate-300 block mb-4">event_busy</span>
            <h3 class="text-lg font-bold text-slate-600 dark:text-slate-300 mb-2">Sin citas registradas</h3>
            <p class="text-slate-400 text-sm mb-6">Agenda tu primera cita con una de nuestras psicólogas.</p>
            <button onclick="openChatbotModal()"
                class="px-6 py-3 text-white font-bold rounded-xl"
                style="background:#6B8CAE;">
                Agendar ahora
            </button>
        </div>
    <?php else: ?>
        <div id="citasContainer" class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <?php foreach ($citas as $cita):
                $fechaF   = date('d M Y', strtotime($cita['fecha']));
                $horaF    = date('h:i A', strtotime($cita['hora']));
                $esPasada = $cita['fecha'] < date('Y-m-d');
                $estado   = $cita['estado'];
                $partes   = explode(' ', trim($cita['psicologo_nombre']));
                $iniciales = strtoupper(($partes[0][0] ?? '') . ($partes[1][0] ?? ''));
                $badgeClass = match($estado) {
                    'pendiente'  => 'badge-pendiente',
                    'completada' => 'badge-completada',
                    'cancelada'  => 'badge-cancelada',
                    'en proceso' => 'badge-en-proceso',
                    default      => '',
                };
            ?>
            <div class="cita-card rounded-2xl p-5 border border-white/60 dark:border-slate-700/50 flex flex-col"
                 data-estado="<?= $estado ?>">

                <!-- Fila superior: Avatar + Nombre + Badge -->
                <div class="flex items-center gap-3 mb-2">
                    <div class="cita-avatar shrink-0"><?= $iniciales ?></div>
                    <div class="min-w-0">
                        <div class="flex items-center gap-2 flex-wrap">
                            <span class="font-bold text-slate-800 dark:text-slate-100 text-sm leading-tight">
                                <?= htmlspecialchars($cita['psicologo_nombre']) ?>
                            </span>
                            <span class="badge <?= $badgeClass ?>"><?= ucfirst($estado) ?></span>
                        </div>
                        <p class="text-xs text-slate-400 dark:text-slate-500 mt-0.5">
                            <?= htmlspecialchars($cita['especialidad']) ?>
                        </p>
                    </div>
                </div>

                <!-- Fecha y Hora -->
                <div class="flex items-center gap-4 text-xs text-slate-600 dark:text-slate-300 mb-1.5 pl-1">
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]" style="color:#6B8CAE">calendar_month</span>
                        <?= $fechaF ?>
                    </span>
                    <span class="flex items-center gap-1">
                        <span class="material-symbols-outlined text-[14px]" style="color:#6B8CAE">schedule</span>
                        <?= $horaF ?>
                    </span>
                </div>

                <!-- Motivo -->
                <?php if (!empty($cita['motivo_consulta'])): ?>
                <p class="text-xs text-slate-400 dark:text-slate-500 flex items-center gap-1 pl-1 mb-3">
                    <span class="material-symbols-outlined text-[13px]">notes</span>
                    <?= htmlspecialchars($cita['motivo_consulta']) ?>
                </p>
                <?php else: ?>
                <div class="mb-3"></div>
                <?php endif; ?>

                <!-- Área de botones (parte inferior izquierda) -->
                <?php if ($estado === 'pendiente' && !$esPasada): ?>
                <div class="mt-auto pt-3 border-t border-slate-100 dark:border-slate-700/50 flex items-center gap-2">
                    <button onclick="abrirModalEditar(<?= $cita['id_cita'] ?>, '<?= $cita['fecha'] ?>', '<?= substr($cita['hora'],0,5) ?>', <?= $cita['id_psicologo'] ?>, '<?= htmlspecialchars(addslashes($cita['psicologo_nombre'])) ?>')"
                        class="btn-editar flex-1 justify-center">
                        <span class="material-symbols-outlined text-[15px]">edit</span>
                        Editar
                    </button>
                    <button onclick="cancelarCita(<?= $cita['id_cita'] ?>)"
                        class="btn-cancelar flex-1 justify-center">
                        <span class="material-symbols-outlined text-[15px]">cancel</span>
                        Cancelar
                    </button>
                </div>
                <?php else: ?>
                <!-- Espacio reservado para mantener altura uniforme -->
                <div class="mt-auto pt-3 border-t border-slate-100 dark:border-slate-700/50 h-[44px]"></div>
                <?php endif; ?>

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
            <div class="w-10 h-10 rounded-xl flex items-center justify-center text-white" style="background:#6B8CAE;">
                <span class="material-symbols-outlined">edit_calendar</span>
            </div>
            <div>
                <h3 class="font-bold text-slate-800 dark:text-slate-100 text-lg">Editar Cita</h3>
                <p id="editarPsicologoLabel" class="text-xs" style="color:#6B8CAE;"></p>
            </div>
        </div>
        <input type="hidden" id="editarIdCita">
        <div class="space-y-4">
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Nueva Fecha</label>
                <input type="date" id="editarFecha" min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                    onchange="cargarHorasEditar()"
                    class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-transparent dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-1.5">Psicólogo/a</label>
                <select id="editarPsicologo" onchange="cargarHorasEditar()"
                    class="w-full border-2 border-slate-200 dark:border-slate-600 rounded-xl px-4 py-2.5 bg-white dark:bg-slate-900 text-slate-700 dark:text-slate-200 text-sm focus:outline-none focus:border-blue-400 transition-colors">
                    <?php foreach ($psicologos as $p): ?>
                    <option value="<?= $p['id_psicologo'] ?>"><?= htmlspecialchars($p['nombre']) ?> — <?= htmlspecialchars($p['especialidad']) ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
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
            class="w-full mt-5 py-3 text-white font-bold rounded-xl transition-all active:scale-[0.98] disabled:opacity-50 disabled:cursor-not-allowed"
            style="background:linear-gradient(135deg,#6B8CAE,#5a7e9f);">
            Guardar cambios
        </button>
    </div>
</div>

<!-- ══════════ TOAST ══════════ -->
<div id="citasToast" class="fixed bottom-6 right-6 z-[80] hidden">
    <div id="citasToastInner" class="flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-semibold text-white min-w-[260px]">
        <span class="material-symbols-outlined text-[20px]" id="citasToastIcon">check_circle</span>
        <span id="citasToastMsg"></span>
    </div>
</div>

<script>
const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');

function filtrarCitas(estado) {
    document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
    const activeBtn = document.getElementById('tab-' + estado);
    if (activeBtn) activeBtn.classList.add('active');
    document.querySelectorAll('.cita-card').forEach(card => {
        card.style.display = (estado === 'todas' || card.dataset.estado === estado) ? '' : 'none';
    });
}

async function cancelarCita(idCita) {
    if (!confirm('¿Seguro que quieres cancelar esta cita?')) return;
    try {
        const res  = await fetch(BASE + 'citas/cancelar', {
            method: 'POST', headers: {'Content-Type':'application/json'},
            body: JSON.stringify({ id_cita: idCita })
        });
        const data = await res.json();
        if (data.ok) { mostrarToast(data.mensaje, 'success'); setTimeout(() => location.reload(), 1200); }
        else mostrarToast(data.error, 'error');
    } catch(e) { mostrarToast('Error de conexión.', 'error'); }
}

function abrirModalEditar(idCita, fecha, hora, idPsicologo, nombrePsicologo) {
    document.getElementById('editarIdCita').value      = idCita;
    document.getElementById('editarFecha').value       = fecha;
    document.getElementById('editarPsicologo').value   = idPsicologo;
    document.getElementById('editarPsicologoLabel').textContent = nombrePsicologo;
    document.getElementById('editarHoraSeleccionada').value = hora;
    document.getElementById('editarBtnGuardar').disabled = false;
    document.getElementById('editarError').classList.add('hidden');
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
    const fecha       = document.getElementById('editarFecha').value;
    const idPsicologo = document.getElementById('editarPsicologo').value;
    const grid        = document.getElementById('editarHorasGrid');
    if (!fecha || !idPsicologo) return;
    grid.innerHTML = `<div class="col-span-4 flex justify-center py-2"><div class="w-6 h-6 border-2 border-blue-200 border-t-blue-500 rounded-full animate-spin"></div></div>`;
    document.getElementById('editarHoraSeleccionada').value = '';
    document.getElementById('editarBtnGuardar').disabled = true;
    try {
        const idCita = document.getElementById('editarIdCita').value;
        const res  = await fetch(`${BASE}citas/horasDisponiblesEdicion?fecha=${fecha}&id_psicologo=${idPsicologo}&id_cita=${idCita}`);
        const data = await res.json();
        if (!data.ok || !data.horas.length) {
            grid.innerHTML = `<p class="col-span-4 text-xs text-slate-400 text-center py-2">Sin horas disponibles este día.</p>`;
            return;
        }
        grid.innerHTML = data.horas.map(h => `
            <button onclick="seleccionarHoraEditar('${h}', this)"
                class="hora-edit-btn py-2 text-xs font-semibold border-2 rounded-xl transition-all ${h === horaPreseleccionada ? 'border-blue-500 bg-blue-500 text-white' : 'border-slate-200 text-slate-600 hover:border-blue-400 hover:text-blue-600 hover:bg-blue-50'}">
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
        b.classList.add('border-slate-200','text-slate-600');
    });
    btn.classList.add('border-blue-500','bg-blue-500','text-white');
    btn.classList.remove('border-slate-200','text-slate-600');
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
            mostrarToast('Cita actualizada correctamente', 'success');
            setTimeout(() => location.reload(), 1200);
        } else { errEl.textContent = data.error; errEl.classList.remove('hidden'); }
    } catch(e) { errEl.textContent = 'Error de conexión.'; errEl.classList.remove('hidden'); }
}

function mostrarToast(msg, tipo = 'success') {
    const toast = document.getElementById('citasToast');
    const inner = document.getElementById('citasToastInner');
    document.getElementById('citasToastIcon').textContent = tipo === 'success' ? 'check_circle' : 'error';
    document.getElementById('citasToastMsg').textContent  = msg;
    inner.className = `flex items-center gap-3 px-5 py-3.5 rounded-2xl shadow-xl text-sm font-semibold text-white min-w-[260px] ${tipo === 'success' ? 'bg-green-500' : 'bg-red-500'}`;
    toast.classList.remove('hidden');
    setTimeout(() => toast.classList.add('hidden'), 3000);
}

window.URL_BASE = '<?= URL_BASE ?>';
</script>
