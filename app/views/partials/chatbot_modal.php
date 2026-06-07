<!-- ═══════════════════════════════════════════════════════════
     MODAL DEL CHATBOT — se incluye en el layout global
     Se abre con: openChatbotModal()
     ═══════════════════════════════════════════════════════════ -->

<div id="chatbotModal" class="fixed inset-0 z-50 hidden flex-col justify-end" role="dialog" aria-modal="true" aria-labelledby="chatbotTitle">
    <!-- Backdrop oscuro -->
    <div id="chatbotBackdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeChatbotModal()"></div>

    <!-- Drawer Inferior -->
    <div id="chatbotDrawer" class="relative w-full max-w-3xl mx-auto bg-white rounded-t-[32px] shadow-[0_-8px_40px_rgba(0,0,0,0.15)] p-6 md:p-8 transform transition-transform duration-300 max-h-[92vh] overflow-y-auto">
        
        <!-- Botón cerrar -->
        <button onclick="closeChatbotModal()" class="absolute top-5 right-5 p-2 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors focus:outline-none z-10">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>

        <!-- Handle visual -->
        <div class="flex justify-center mb-6">
            <div class="w-10 h-1.5 bg-slate-200 rounded-full cursor-pointer" onclick="closeChatbotModal()"></div>
        </div>
        
        <!-- ══════════════ PASO 0: MENÚ INICIAL ══════════════ -->
        <div id="cbStep0" class="cb-step">
            <div class="mb-8 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-orange-400 to-orange-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-orange-200">
                    <span class="material-symbols-outlined text-white text-[32px]">smart_toy</span>
                </div>
                <h2 id="chatbotTitle" class="text-xl font-bold text-slate-800 mb-1">Hola, ¿en qué te puedo ayudar?</h2>
                <p class="text-sm text-slate-500">Selecciona una de las opciones para comenzar.</p>
            </div>
            
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                <!-- Agendar Cita -->
                <button onclick="cbGoToStep1()" class="group flex flex-col items-center justify-center p-5 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-md hover:border-orange-300 hover:bg-orange-50/40 transition-all active:scale-[0.97] duration-150 w-full">
                    <div class="w-12 h-12 rounded-xl bg-orange-50 text-orange-500 flex items-center justify-center mb-3 group-hover:bg-orange-500 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">calendar_month</span>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 text-center">Agendar Cita</span>
                </button>
                
                <!-- Cancelar Cita -->
                <button class="group flex flex-col items-center justify-center p-5 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-md hover:border-slate-300 transition-all active:scale-[0.97] duration-150 w-full opacity-60 cursor-not-allowed">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[28px]">cancel</span>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 text-center">Cancelar Cita</span>
                </button>
                
                <!-- Reprogramar -->
                <button class="group flex flex-col items-center justify-center p-5 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-md hover:border-slate-300 transition-all active:scale-[0.97] duration-150 w-full opacity-60 cursor-not-allowed">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[28px]">sync</span>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 text-center">Reprogramar</span>
                </button>
                
                <!-- Recursos -->
                <button class="group flex flex-col items-center justify-center p-5 bg-white border-2 border-slate-100 rounded-2xl shadow-sm hover:shadow-md hover:border-slate-300 transition-all active:scale-[0.97] duration-150 w-full opacity-60 cursor-not-allowed">
                    <div class="w-12 h-12 rounded-xl bg-slate-50 text-slate-400 flex items-center justify-center mb-3">
                        <span class="material-symbols-outlined text-[28px]">auto_stories</span>
                    </div>
                    <span class="text-sm font-semibold text-slate-500 text-center">Recursos</span>
                </button>
            </div>
            <div class="h-4"></div>
        </div>

        <!-- ══════════════ PASO 1: SELECCIONAR FECHA ══════════════ -->
        <div id="cbStep1" class="cb-step hidden">
            <div class="mb-6">
                <button onclick="cbGoToStep(0)" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-orange-500 transition-colors mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Volver
                </button>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800">Agendar Cita</h3>
                </div>
                <p class="text-sm text-slate-500 pl-12">Selecciona la fecha para tu cita</p>
            </div>

            <div class="bg-slate-50 rounded-2xl p-5 mb-5">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Fecha de la cita</label>
                <input 
                    type="date" 
                    id="cbFecha" 
                    min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                    class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 text-slate-800 font-medium focus:outline-none focus:border-orange-400 transition-colors text-base"
                >
            </div>

            <button onclick="cbBuscarPsicologos()" id="cbBtnBuscar"
                class="w-full py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all active:scale-[0.98] shadow-md shadow-orange-200 flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">search</span>
                Ver psicólogos disponibles
            </button>

            <div id="cbError1" class="hidden mt-3 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                <span id="cbError1Msg"></span>
            </div>
        </div>

        <!-- ══════════════ PASO 2: SELECCIONAR PSICÓLOGO ══════════════ -->
        <div id="cbStep2" class="cb-step hidden">
            <div class="mb-5">
                <button onclick="cbGoToStep(1)" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-orange-500 transition-colors mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Cambiar fecha
                </button>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">group</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Psicólogos disponibles</h3>
                        <p id="cbFechaLabel" class="text-xs text-orange-500 font-medium"></p>
                    </div>
                </div>
            </div>

            <div id="cbPsicologosList" class="space-y-3 mb-2">
                <!-- Psicólogos se insertan aquí por JS -->
            </div>
            <div class="h-2"></div>
        </div>

        <!-- ══════════════ PASO 3: SELECCIONAR HORA ══════════════ -->
        <div id="cbStep3" class="cb-step hidden">
            <div class="mb-5">
                <button onclick="cbGoToStep(2)" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-orange-500 transition-colors mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Cambiar psicólogo
                </button>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-orange-100 text-orange-600 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">schedule</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800">Horas disponibles</h3>
                        <p id="cbPsicologoLabel" class="text-xs text-orange-500 font-medium"></p>
                    </div>
                </div>
            </div>

            <div id="cbHorasList" class="grid grid-cols-3 gap-2 mb-5">
                <!-- Horas se insertan aquí por JS -->
            </div>

            <!-- Motivo de consulta -->
            <div class="bg-slate-50 rounded-2xl p-4 mb-5">
                <label class="block text-xs font-semibold text-slate-500 uppercase tracking-wider mb-2">Motivo de consulta <span class="text-slate-400 font-normal">(opcional)</span></label>
                <textarea id="cbMotivo" rows="3" placeholder="Ej: Ansiedad, dificultades emocionales..."
                    class="w-full bg-white border-2 border-slate-200 rounded-xl px-4 py-3 text-slate-700 text-sm focus:outline-none focus:border-orange-400 transition-colors resize-none"></textarea>
            </div>

            <button onclick="cbConfirmarCita()" id="cbBtnConfirmar" disabled
                class="w-full py-3.5 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-semibold rounded-xl hover:from-orange-600 hover:to-orange-700 transition-all active:scale-[0.98] shadow-md shadow-orange-200 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
                <span class="material-symbols-outlined text-[20px]">check_circle</span>
                Confirmar cita
            </button>

            <div id="cbError3" class="hidden mt-3 p-3 bg-red-50 border border-red-200 rounded-xl text-sm text-red-600 flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">error</span>
                <span id="cbError3Msg"></span>
            </div>
        </div>

        <!-- ══════════════ PASO 4: CONFIRMACIÓN FINAL ══════════════ -->
        <div id="cbStep4" class="cb-step hidden">
            <div class="text-center py-6">
                <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-5">
                    <span class="material-symbols-outlined text-green-500 text-[44px]">check_circle</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 mb-2">¡Cita agendada!</h3>
                <p class="text-sm text-slate-500 mb-6">Tu cita ha sido registrada exitosamente.</p>

                <div id="cbResumen" class="bg-gradient-to-br from-orange-50 to-amber-50 border border-orange-100 rounded-2xl p-5 text-left space-y-3 mb-6">
                    <!-- Resumen insertado por JS -->
                </div>

                <button onclick="cbReset()" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 font-semibold rounded-xl transition-colors">
                    Volver al menú principal
                </button>
            </div>
        </div>

        <!-- ══════════════ LOADING OVERLAY ══════════════ -->
        <div id="cbLoading" class="hidden absolute inset-0 bg-white/80 backdrop-blur-sm rounded-t-[32px] flex items-center justify-center z-20">
            <div class="flex flex-col items-center gap-3">
                <div class="w-10 h-10 border-4 border-orange-200 border-t-orange-500 rounded-full animate-spin"></div>
                <p class="text-sm text-slate-500 font-medium">Consultando disponibilidad...</p>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes slideUp {
        from { transform: translateY(60px); opacity: 0; }
        to   { transform: translateY(0);    opacity: 1; }
    }
    #chatbotDrawer {
        animation: slideUp 0.3s ease-out;
    }
    .cb-step { transition: opacity 0.2s ease; }
</style>

<script>
// ─── Estado del chatbot ───────────────────────────────────────────────
const CB = {
    fecha: '',
    diaSemana: '',
    psicologoId: null,
    psicologoNombre: '',
    hora: null,
};

// ─── Navegación ───────────────────────────────────────────────────────
function openChatbotModal() {
    const m = document.getElementById('chatbotModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
}

function closeChatbotModal() {
    const m = document.getElementById('chatbotModal');
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}

function cbGoToStep(n) {
    document.querySelectorAll('.cb-step').forEach(el => el.classList.add('hidden'));
    document.getElementById('cbStep' + n).classList.remove('hidden');
}

function cbGoToStep1() { cbGoToStep(1); }

// ─── Buscar psicólogos disponibles ────────────────────────────────────
async function cbBuscarPsicologos() {
    const fecha = document.getElementById('cbFecha').value;
    const errEl  = document.getElementById('cbError1');
    const errMsg = document.getElementById('cbError1Msg');

    errEl.classList.add('hidden');

    if (!fecha) {
        errMsg.textContent = 'Por favor selecciona una fecha.';
        errEl.classList.remove('hidden');
        return;
    }

    const hoy = new Date(); hoy.setHours(0,0,0,0);
    const sel = new Date(fecha + 'T00:00:00');
    if (sel <= hoy) {
        errMsg.textContent = 'La fecha debe ser futura (mínimo mañana).';
        errEl.classList.remove('hidden');
        return;
    }

    CB.fecha = fecha;
    cbShowLoading(true);

    try {
        const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
        const res  = await fetch(BASE + 'chat_bot/psicologosDisponibles?fecha=' + fecha);
        const data = await res.json();

        if (!data.ok) throw new Error(data.error || 'Error desconocido');
        if (!data.psicologos || data.psicologos.length === 0) {
            errMsg.textContent = 'No hay psicólogos disponibles el día ' + data.dia + '. Prueba con otra fecha.';
            errEl.classList.remove('hidden');
            cbShowLoading(false);
            return;
        }

        CB.diaSemana = data.dia;
        cbRenderPsicologos(data.psicologos, fecha, data.dia);
        cbGoToStep(2);
    } catch (e) {
        errMsg.textContent = 'Error al consultar disponibilidad: ' + e.message;
        errEl.classList.remove('hidden');
    } finally {
        cbShowLoading(false);
    }
}

function cbRenderPsicologos(lista, fecha, dia) {
    const container = document.getElementById('cbPsicologosList');
    document.getElementById('cbFechaLabel').textContent = cbFormatFecha(fecha) + ' · ' + dia;

    container.innerHTML = lista.map(p => `
        <button onclick="cbSeleccionarPsicologo(${p.id_psicologo}, '${escHtml(p.nombre)}')"
            class="w-full flex items-center gap-4 p-4 bg-white border-2 border-slate-100 rounded-2xl hover:border-orange-300 hover:bg-orange-50/30 transition-all active:scale-[0.99] text-left group">
            <img src="${escHtml(p.foto_perfil)}" alt="${escHtml(p.nombre)}"
                class="w-12 h-12 rounded-xl object-cover shrink-0 ring-2 ring-orange-100 group-hover:ring-orange-300 transition-all">
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-slate-800 truncate">${escHtml(p.nombre)}</p>
                <p class="text-xs text-slate-500 truncate">${escHtml(p.especialidad)}</p>
            </div>
            <span class="material-symbols-outlined text-slate-300 group-hover:text-orange-400 transition-colors">chevron_right</span>
        </button>
    `).join('');
}

// ─── Seleccionar psicólogo y buscar horas ─────────────────────────────
async function cbSeleccionarPsicologo(id, nombre) {
    CB.psicologoId     = id;
    CB.psicologoNombre = nombre;
    CB.hora            = null;
    document.getElementById('cbBtnConfirmar').disabled = true;

    cbShowLoading(true);

    try {
        const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
        const url  = BASE + 'chat_bot/horasDisponibles?fecha=' + CB.fecha + '&id_psicologo=' + id;
        const res  = await fetch(url);
        const data = await res.json();

        if (!data.ok) throw new Error(data.error || 'Error desconocido');

        cbRenderHoras(data.horas);
        document.getElementById('cbPsicologoLabel').textContent = nombre + ' · ' + cbFormatFecha(CB.fecha);
        cbGoToStep(3);
    } catch (e) {
        alert('Error al obtener horas: ' + e.message);
    } finally {
        cbShowLoading(false);
    }
}

function cbRenderHoras(horas) {
    const container = document.getElementById('cbHorasList');
    if (!horas || horas.length === 0) {
        container.innerHTML = `
            <div class="col-span-3 text-center py-6 text-slate-400">
                <span class="material-symbols-outlined text-[40px] block mb-2">event_busy</span>
                <p class="text-sm">No hay horas disponibles este día para este psicólogo.</p>
            </div>`;
        return;
    }

    container.innerHTML = horas.map(h => `
        <button onclick="cbSeleccionarHora('${h}', this)"
            data-hora="${h}"
            class="hora-btn py-2.5 px-3 border-2 border-slate-200 rounded-xl text-sm font-semibold text-slate-600 hover:border-orange-400 hover:bg-orange-50 hover:text-orange-600 transition-all active:scale-[0.97]">
            ${h}
        </button>
    `).join('');
}

function cbSeleccionarHora(hora, btn) {
    // Quitar selección anterior
    document.querySelectorAll('.hora-btn').forEach(b => {
        b.classList.remove('border-orange-500', 'bg-orange-500', 'text-white');
        b.classList.add('border-slate-200', 'text-slate-600');
    });
    // Marcar seleccionada
    btn.classList.remove('border-slate-200', 'text-slate-600');
    btn.classList.add('border-orange-500', 'bg-orange-500', 'text-white');

    CB.hora = hora;
    document.getElementById('cbBtnConfirmar').disabled = false;
}

// ─── Confirmar y guardar la cita ──────────────────────────────────────
async function cbConfirmarCita() {
    if (!CB.hora) return;

    const motivo = document.getElementById('cbMotivo').value.trim();
    const errEl  = document.getElementById('cbError3');
    const errMsg = document.getElementById('cbError3Msg');
    errEl.classList.add('hidden');

    cbShowLoading(true);

    try {
        const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
        const res  = await fetch(BASE + 'chat_bot/guardarCita', {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                fecha:            CB.fecha,
                id_psicologo:     CB.psicologoId,
                hora:             CB.hora,
                motivo_consulta:  motivo,
            })
        });
        const data = await res.json();

        if (!data.ok) throw new Error(data.error || 'Error al guardar');

        // Mostrar resumen
        const resumen = document.getElementById('cbResumen');
        resumen.innerHTML = `
            <div class="flex items-center gap-3 pb-3 border-b border-orange-100">
                <span class="material-symbols-outlined text-orange-400 text-[20px]">person</span>
                <div>
                    <p class="text-xs text-slate-400">Psicólogo</p>
                    <p class="font-semibold text-slate-700 text-sm">${escHtml(CB.psicologoNombre)}</p>
                </div>
            </div>
            <div class="flex items-center gap-3 pb-3 border-b border-orange-100">
                <span class="material-symbols-outlined text-orange-400 text-[20px]">calendar_month</span>
                <div>
                    <p class="text-xs text-slate-400">Fecha</p>
                    <p class="font-semibold text-slate-700 text-sm">${cbFormatFecha(CB.fecha)} · ${CB.diaSemana}</p>
                </div>
            </div>
            <div class="flex items-center gap-3">
                <span class="material-symbols-outlined text-orange-400 text-[20px]">schedule</span>
                <div>
                    <p class="text-xs text-slate-400">Hora</p>
                    <p class="font-semibold text-slate-700 text-sm">${CB.hora}</p>
                </div>
            </div>
            ${motivo ? `
            <div class="flex items-start gap-3 pt-3 border-t border-orange-100">
                <span class="material-symbols-outlined text-orange-400 text-[20px] mt-0.5">notes</span>
                <div>
                    <p class="text-xs text-slate-400">Motivo</p>
                    <p class="text-sm text-slate-600">${escHtml(motivo)}</p>
                </div>
            </div>` : ''}
        `;
        cbGoToStep(4);
    } catch (e) {
        errMsg.textContent = e.message;
        errEl.classList.remove('hidden');
    } finally {
        cbShowLoading(false);
    }
}

// ─── Reset ────────────────────────────────────────────────────────────
function cbReset() {
    CB.fecha = ''; CB.diaSemana = ''; CB.psicologoId = null;
    CB.psicologoNombre = ''; CB.hora = null;
    document.getElementById('cbFecha').value = '';
    document.getElementById('cbMotivo').value = '';
    cbGoToStep(0);
}

// ─── Helpers ──────────────────────────────────────────────────────────
function cbShowLoading(show) {
    document.getElementById('cbLoading').classList.toggle('hidden', !show);
}

function cbFormatFecha(fecha) {
    const [y, m, d] = fecha.split('-');
    const meses = ['ene','feb','mar','abr','may','jun','jul','ago','sep','oct','nov','dic'];
    return `${parseInt(d)} ${meses[parseInt(m)-1]}. ${y}`;
}

function escHtml(str) {
    if (!str) return '';
    return String(str).replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

// URL_BASE inyectada desde PHP para que el JS pueda llamar a la API
window.URL_BASE = '<?= URL_BASE ?>';

document.addEventListener('keydown', e => {
    if (e.key === 'Escape') closeChatbotModal();
});
</script>
