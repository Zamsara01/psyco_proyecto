<?php
/**
 * Vista: Notas para Pacientes de Hoy (Psicóloga)
 * Variables: $pacientesHoy[]
 */
?>
<div class="p-6 md:p-8 max-w-6xl mx-auto w-full">

    <div class="flex items-center gap-4 mb-8">
        <a href="<?= URL_BASE ?>panel_psicologas" class="w-10 h-10 rounded-full bg-slate-100 flex items-center justify-center text-slate-500 hover:bg-slate-200 hover:text-slate-800 transition-colors">
            <span class="material-symbols-outlined">arrow_back</span>
        </a>
        <div>
            <h1 class="text-2xl font-black text-slate-900">Notas para Pacientes de Hoy</h1>
            <p class="text-slate-500 text-sm mt-1">Gestiona las notas y recomendaciones para tus pacientes del día</p>
        </div>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-12 gap-6">
        
        <!-- Sidebar: Lista de Pacientes -->
        <div class="md:col-span-4 bg-white rounded-2xl shadow-sm border border-slate-100 overflow-hidden h-[calc(100vh-200px)] flex flex-col">
            <div class="p-4 border-b border-slate-100 bg-slate-50/50">
                <h3 class="font-bold text-slate-800">Pacientes programados</h3>
                <p class="text-xs text-slate-500"><?= count($pacientesHoy) ?> paciente(s) hoy</p>
            </div>
            
            <div class="flex-1 overflow-y-auto p-3 space-y-2">
                <?php if (empty($pacientesHoy)): ?>
                    <p class="text-center text-slate-400 text-sm py-10">No hay pacientes hoy.</p>
                <?php else: ?>
                    <?php foreach ($pacientesHoy as $idx => $pac): ?>
                        <button onclick="cargarNotasPaciente(<?= $pac['id_usuario'] ?>, '<?= htmlspecialchars(addslashes($pac['paciente_nombre'])) ?>', this)"
                            class="paciente-tab-btn w-full text-left flex items-center justify-between p-3 rounded-xl transition-all <?= $idx === 0 ? 'bg-purple-50 border-2 border-purple-200' : 'bg-white border-2 border-transparent hover:bg-slate-50' ?>">
                            <span class="font-semibold <?= $idx === 0 ? 'text-purple-700' : 'text-slate-700' ?>">
                                <?= htmlspecialchars($pac['paciente_nombre']) ?>
                            </span>
                            <?php if ($pac['total_notas'] > 0): ?>
                                <span class="w-6 h-6 rounded-full bg-purple-100 text-purple-600 flex items-center justify-center text-[10px] font-bold">
                                    <?= $pac['total_notas'] ?>
                                </span>
                            <?php endif; ?>
                        </button>
                    <?php endforeach; ?>
                <?php endif; ?>
            </div>
        </div>

        <!-- Main: Detalle de Notas -->
        <div class="md:col-span-8 bg-white rounded-2xl shadow-sm border border-slate-100 h-[calc(100vh-200px)] flex flex-col">
            <?php if (empty($pacientesHoy)): ?>
                <div class="flex-1 flex flex-col items-center justify-center text-slate-400">
                    <span class="material-symbols-outlined text-[64px] text-slate-200 mb-4">event_busy</span>
                    <p>No tienes citas programadas para hoy.</p>
                </div>
            <?php else: ?>
                <div class="p-5 border-b border-slate-100 flex items-center justify-between bg-slate-50/50 shrink-0">
                    <div class="flex items-center gap-3">
                        <div class="w-10 h-10 rounded-full bg-purple-100 flex items-center justify-center text-purple-600 font-bold" id="detalleInicial">
                            <?= strtoupper(substr($pacientesHoy[0]['paciente_nombre'] ?? '?', 0, 1)) ?>
                        </div>
                        <div>
                            <h2 class="font-bold text-slate-800 text-lg" id="detalleNombre"><?= htmlspecialchars($pacientesHoy[0]['paciente_nombre'] ?? '') ?></h2>
                            <p class="text-xs text-slate-500">Historial de notas</p>
                        </div>
                    </div>
                    <button id="btnNuevaNota" onclick="abrirNotaRapida(<?= $pacientesHoy[0]['id_usuario'] ?? 0 ?>, '<?= htmlspecialchars(addslashes($pacientesHoy[0]['paciente_nombre'] ?? '')) ?>')"
                        class="px-4 py-2 bg-purple-600 text-white text-sm font-bold rounded-xl hover:bg-purple-700 transition-colors shadow-sm shadow-purple-200 flex items-center gap-2">
                        <span class="material-symbols-outlined text-[18px]">add</span> Nueva Nota
                    </button>
                </div>

                <div class="flex-1 overflow-y-auto p-6 bg-slate-50/30" id="detalleNotasContainer">
                    <div class="flex justify-center py-10">
                        <div class="w-8 h-8 border-4 border-purple-200 border-t-purple-500 rounded-full animate-spin"></div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Reutilizamos el modal de nueva nota -->
<div id="notaRapidaModal" class="fixed inset-0 z-[60] hidden items-center justify-center">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="cerrarNotaRapida()"></div>
    <div class="relative bg-white rounded-3xl shadow-2xl w-full max-w-md mx-4 z-10 p-7">
        <button onclick="cerrarNotaRapida()" class="absolute top-4 right-4 p-2 rounded-full hover:bg-slate-100 text-slate-400 transition-colors">
            <span class="material-symbols-outlined">close</span>
        </button>
        <h3 class="font-bold text-slate-800 text-lg mb-1">Nueva nota para</h3>
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
                <textarea id="notaRapidaContenido" rows="5" placeholder="Escribe la nota o recomendación para el paciente..."
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

// Cargar primer paciente al iniciar
window.addEventListener('DOMContentLoaded', () => {
    const primerBtn = document.querySelector('.paciente-tab-btn');
    if (primerBtn) primerBtn.click();
});

async function cargarNotasPaciente(idUsuario, nombre, btn) {
    // UI Update
    document.querySelectorAll('.paciente-tab-btn').forEach(b => {
        b.classList.remove('bg-purple-50', 'border-purple-200');
        b.classList.add('bg-white', 'border-transparent');
        b.querySelector('span:first-child').classList.remove('text-purple-700');
        b.querySelector('span:first-child').classList.add('text-slate-700');
    });
    
    if (btn) {
        btn.classList.remove('bg-white', 'border-transparent');
        btn.classList.add('bg-purple-50', 'border-purple-200');
        btn.querySelector('span:first-child').classList.remove('text-slate-700');
        btn.querySelector('span:first-child').classList.add('text-purple-700');
    }

    document.getElementById('detalleNombre').textContent = nombre;
    document.getElementById('detalleInicial').textContent = nombre.charAt(0).toUpperCase();
    
    const btnNueva = document.getElementById('btnNuevaNota');
    btnNueva.setAttribute('onclick', `abrirNotaRapida(${idUsuario}, '${esc(nombre)}')`);

    const container = document.getElementById('detalleNotasContainer');
    container.innerHTML = `<div class="flex justify-center py-10"><div class="w-8 h-8 border-4 border-purple-200 border-t-purple-500 rounded-full animate-spin"></div></div>`;

    try {
        const res  = await fetch(BASE + 'panel_psicologas/notasPaciente?id_usuario=' + idUsuario);
        const data = await res.json();
        
        if (!data.ok) throw new Error(data.error);

        if (!data.notas.length) {
            container.innerHTML = `
                <div class="flex flex-col items-center justify-center h-full text-slate-400">
                    <span class="material-symbols-outlined text-[48px] text-slate-200 mb-3">sticky_note_2</span>
                    <p>Este paciente aún no tiene notas personalizadas.</p>
                </div>
            `;
            return;
        }

        container.innerHTML = `<div class="space-y-4">` + data.notas.map(n => `
            <div class="bg-white p-5 rounded-2xl border-2 border-slate-100 hover:border-purple-200 transition-colors shadow-sm">
                <div class="flex justify-between items-start mb-2">
                    <h4 class="font-bold text-slate-800 text-lg">${esc(n.titulo)}</h4>
                    <span class="text-xs text-slate-400 bg-slate-50 px-2 py-1 rounded-md border border-slate-100">
                        ${n.fecha_creacion?.slice(0,16).replace('T', ' ') || ''}
                    </span>
                </div>
                <p class="text-slate-600 text-sm whitespace-pre-wrap leading-relaxed">${esc(n.contenido)}</p>
            </div>
        `).join('') + `</div>`;

    } catch(e) {
        container.innerHTML = `<p class="text-red-500 text-center py-10">Error: ${e.message}</p>`;
    }
}

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
            const btnPaciente = document.querySelector(`.paciente-tab-btn[onclick*="${idUsuario}"]`);
            
            // Cargar de nuevo la vista de notas con el ID y nombre actualizados
            cargarNotasPaciente(idUsuario, nombrePaciente, btnPaciente);
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
</script>
