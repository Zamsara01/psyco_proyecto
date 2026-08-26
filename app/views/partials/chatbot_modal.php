<?php
$cb_tieneCitaPendiente = false;
$cb_tieneCitaAlguna = false;
$cb_citasPendientesJSON = '[]';
$cb_userRol = $_SESSION['user']['rol'] ?? '';

if (!empty($_SESSION['user'])) {
    if (!class_exists('CitaModel', false)) {
        require_once dirname(__DIR__, 2) . '/models/CitaModel.php';
    }
    $cb_citaModel = new CitaModel();
    $pendientes = [];

    if ($cb_userRol === 'paciente') {
        $cb_citasUser = $cb_citaModel->getCitasUsuario((int)$_SESSION['user']['id']);
        if (!empty($cb_citasUser)) {
            $cb_tieneCitaAlguna = true;
            foreach ($cb_citasUser as $c) {
                if ($c['estado'] === 'pendiente' && $c['fecha'] >= date('Y-m-d')) {
                    $cb_tieneCitaPendiente = true;
                    $pendientes[] = [
                        'id_cita' => $c['id_cita'],
                        'fecha' => $c['fecha'],
                        'hora' => substr($c['hora'], 0, 5),
                        'id_psicologo' => $c['id_psicologo'],
                        'psicologo_nombre' => $c['psicologo_nombre'],
                        'especialidad' => $c['especialidad'],
                        'foto_perfil' => $c['foto_perfil']
                    ];
                }
            }
        }
    } elseif ($cb_userRol === 'psicologo') {
        $cb_citasPsicologa = $cb_citaModel->getCitasPendientesPsicologo((int)$_SESSION['user']['id']);
        if (!empty($cb_citasPsicologa)) {
            $cb_tieneCitaAlguna = true;
            $cb_tieneCitaPendiente = true;
            foreach ($cb_citasPsicologa as $c) {
                $pendientes[] = [
                    'id_cita' => $c['id_cita'],
                    'id_usuario' => $c['id_usuario'],
                    'fecha' => $c['fecha'],
                    'hora' => substr($c['hora'], 0, 5),
                    'paciente_nombre' => $c['paciente_nombre']
                ];
            }
        }
    }
    $cb_citasPendientesJSON = json_encode($pendientes);
}
?>
<!-- ═══════════════════════════════════════════════════════════
     MODAL DEL CHATBOT — se incluye en el layout global
     Se abre con: openChatbotModal()
     ═══════════════════════════════════════════════════════════ -->

<div id="chatbotModal" class="fixed inset-0 z-50 hidden flex-col justify-end" role="dialog" aria-modal="true" aria-labelledby="chatbotTitle">
    <!-- Backdrop oscuro -->
    <div id="chatbotBackdrop" class="absolute inset-0 bg-black/40 backdrop-blur-sm transition-opacity" onclick="closeChatbotModal()"></div>

    <!-- Drawer Inferior -->
    <div id="chatbotDrawer" class="relative w-full max-w-3xl mx-auto bg-white dark:bg-slate-900 rounded-t-[32px] shadow-[0_-8px_40px_rgba(0,0,0,0.15)] p-6 md:p-8 transform transition-transform duration-300 max-h-[92vh] overflow-y-auto">
        
        <!-- Botón cerrar -->
        <button onclick="closeChatbotModal()" class="absolute top-5 right-5 p-2 rounded-full text-slate-400 hover:bg-slate-100 dark:hover:bg-slate-800 hover:text-slate-700 dark:hover:text-slate-200 transition-colors focus:outline-none z-10">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>

        <!-- Handle visual -->
        <div class="flex justify-center mb-6">
            <div class="w-10 h-1.5 bg-slate-200 dark:bg-slate-700 rounded-full cursor-pointer" onclick="closeChatbotModal()"></div>
        </div>
        
        <!-- ──════════════ PASO 0: MENÚ INICIAL ════════════── -->
        <div id="cbStep0" class="cb-step">
            <div class="mb-8 text-center">
                <div class="w-16 h-16 rounded-2xl bg-gradient-to-br from-blue-500 to-emerald-600 flex items-center justify-center mx-auto mb-4 shadow-lg shadow-blue-100 dark:shadow-none">
                    <span class="material-symbols-outlined text-white text-[32px]">smart_toy</span>
                </div>
                <h2 id="chatbotTitle" class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-1">Hola, estamos aquí para ti. ¿En qué podemos ayudarte?</h2>
                <p class="text-sm text-slate-500 dark:text-slate-400">Selecciona una de las opciones para comenzar.</p>
            </div>
            
            <div class="grid grid-cols-2 gap-3 md:gap-4">
                <!-- Agendar Cita -->
                <button onclick="cbGoToStep1()" class="group flex flex-col items-center justify-center p-5 bg-white border-2 border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50/40 dark:hover:bg-blue-900/30 transition-all active:scale-[0.97] duration-150 w-full">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/50 text-blue-500 dark:text-blue-400 flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">calendar_month</span>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 text-center">Agendar Cita</span>
                </button>
                
                <!-- Cancelar Cita -->
                <button onclick="cbGoToCancelList()" 
                    class="group flex flex-col items-center justify-center p-5 bg-white border-2 border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50/40 dark:hover:bg-blue-900/30 transition-all active:scale-[0.97] duration-150 w-full">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/50 text-blue-500 dark:text-blue-400 flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">cancel</span>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 text-center">Cancelar Cita</span>
                </button>
                
                <!-- Reprogramar -->
                <button onclick="cbGoToReprogramList()" 
                    class="group flex flex-col items-center justify-center p-5 bg-white border-2 border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50/40 dark:hover:bg-blue-900/30 transition-all active:scale-[0.97] duration-150 w-full">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/50 text-blue-500 dark:text-blue-400 flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">sync</span>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 text-center">Reprogramar</span>
                </button>
                
                <!-- Recursos -->
                <button onclick="window.location.href='<?= URL_BASE ?><?= ($cb_userRol === 'psicologo') ? 'panel_psicologas/recursos' : 'citas/misRecursos' ?>'" 
                    class="group flex flex-col items-center justify-center p-5 bg-white border-2 border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl shadow-sm hover:shadow-md hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50/40 dark:hover:bg-blue-900/30 transition-all active:scale-[0.97] duration-150 w-full">
                    <div class="w-12 h-12 rounded-xl bg-blue-50 dark:bg-blue-900/50 text-blue-500 dark:text-blue-400 flex items-center justify-center mb-3 group-hover:bg-blue-600 group-hover:text-white transition-colors">
                        <span class="material-symbols-outlined text-[28px]">auto_stories</span>
                    </div>
                    <span class="text-sm font-semibold text-slate-700 dark:text-slate-200 text-center">Recursos</span>
                </button>

            </div>
            <div class="h-4"></div>
        </div>

        <!-- ══════════════ PASO 1: SELECCIONAR FECHA ══════════════ -->
        <div id="cbStep1" class="cb-step hidden">
            <div class="mb-6">
                <button onclick="cbGoToStep(0)" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-500 dark:text-slate-400 dark:hover:text-blue-400 transition-colors mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Volver
                </button>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    </div>
                    <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Agendar Cita</h3>
                </div>
                <p class="text-sm text-slate-500 dark:text-slate-400 pl-12">Selecciona la fecha para tu cita</p>
            </div>

            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-5 mb-5">
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Fecha de la cita</label>
                <input 
                    type="date" 
                    id="cbFecha" 
                    min="<?= date('Y-m-d', strtotime('+1 day')) ?>"
                    class="w-full bg-white border-2 border-slate-200 dark:bg-slate-800 dark:border-slate-600 rounded-xl px-4 py-3 text-slate-800 dark:text-slate-100 font-medium focus:outline-none focus:border-blue-400 transition-colors text-base"
                >
            </div>

            <button onclick="cbBuscarPsicologos()" id="cbBtnBuscar"
                class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all active:scale-[0.98] shadow-md shadow-blue-100 flex items-center justify-center gap-2">
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
                <button onclick="cbGoToStep(1)" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-500 dark:text-slate-400 dark:hover:text-blue-400 transition-colors mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Cambiar fecha
                </button>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">group</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Psicólogos disponibles</h3>
                        <p id="cbFechaLabel" class="text-xs text-blue-500 font-medium"></p>
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
                <button onclick="cbGoToStep(2)" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-500 dark:text-slate-400 dark:hover:text-blue-400 transition-colors mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Cambiar psicólogo
                </button>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]">schedule</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100">Horas disponibles</h3>
                        <p id="cbPsicologoLabel" class="text-xs text-blue-500 font-medium"></p>
                    </div>
                </div>
            </div>

            <div id="cbHorasList" class="grid grid-cols-3 gap-2 mb-5">
                <!-- Horas se insertan aquí por JS -->
            </div>

            <!-- Motivo de consulta -->
            <div class="bg-slate-50 dark:bg-slate-800/50 rounded-2xl p-4 mb-5">
                <label class="block text-xs font-semibold text-slate-500 dark:text-slate-400 uppercase tracking-wider mb-2">Motivo de consulta <span class="text-slate-400 dark:text-slate-500 font-normal">(opcional)</span></label>
                <textarea id="cbMotivo" rows="3" placeholder="Ej: Ansiedad, dificultades emocionales..."
                    class="w-full bg-white border-2 border-slate-200 dark:bg-slate-800 dark:border-slate-600 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-100 text-sm focus:outline-none focus:border-blue-400 transition-colors resize-none"></textarea>
            </div>

            <button onclick="cbConfirmarCita()" id="cbBtnConfirmar" disabled
                class="w-full py-3.5 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all active:scale-[0.98] shadow-md shadow-blue-100 disabled:opacity-50 disabled:cursor-not-allowed flex items-center justify-center gap-2">
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
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">¡Cita agendada!</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Tu cita ha sido registrada exitosamente.</p>

                <div id="cbResumen" class="bg-gradient-to-br from-blue-50/60 to-emerald-50/70 border border-blue-100 dark:from-blue-900/20 dark:to-emerald-900/20 dark:border-blue-800/50 rounded-2xl p-5 text-left space-y-3 mb-6">
                    <!-- Resumen insertado por JS -->
                </div>

                <button onclick="cbReset()" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 font-semibold rounded-xl transition-colors">
                    Volver al menú principal
                </button>
            </div>
        </div>

        <!-- ══════════════ PASO 5: LISTA DE CITAS PENDIENTES ══════════════ -->
        <div id="cbStep5" class="cb-step hidden">
            <div class="mb-5">
                <button onclick="cbGoToStep(0)" class="flex items-center gap-1.5 text-sm text-slate-500 hover:text-blue-500 dark:text-slate-400 dark:hover:text-blue-400 transition-colors mb-4">
                    <span class="material-symbols-outlined text-[18px]">arrow_back</span> Volver
                </button>
                <div class="flex items-center gap-3 mb-1">
                    <div class="w-9 h-9 rounded-xl bg-blue-100 text-blue-600 dark:bg-blue-900/50 dark:text-blue-400 flex items-center justify-center">
                        <span class="material-symbols-outlined text-[20px]" id="cbStep5Icon">list</span>
                    </div>
                    <div>
                        <h3 class="text-lg font-bold text-slate-800 dark:text-slate-100" id="cbStep5Title">Selecciona una cita</h3>
                        <p class="text-xs text-blue-500 font-medium" id="cbStep5Subtitle"></p>
                    </div>
                </div>
            </div>

            <div id="cbCitasPendientesList" class="space-y-3 mb-5 max-h-[300px] overflow-y-auto pr-1">
                <!-- Citas insertadas por JS -->
            </div>
        </div>

        <!-- ══════════════ PASO 6: CONFIRMAR CANCELACIÓN ══════════════ -->
        <div id="cbStep6" class="cb-step hidden">
            <div class="text-center py-6">
                <div class="w-20 h-20 rounded-full bg-red-100 flex items-center justify-center mx-auto mb-5">
                    <span class="material-symbols-outlined text-red-500 text-[44px]">warning</span>
                </div>
                <h3 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">¿Cancelar cita?</h3>
                <p class="text-sm text-slate-500 dark:text-slate-400 mb-6">Esta acción no se puede deshacer.</p>

                <div id="cbCancelResumen" class="bg-red-50 border border-red-100 dark:bg-red-900/20 dark:border-red-900/50 rounded-2xl p-5 text-left space-y-3 mb-6">
                    <!-- Resumen a cancelar -->
                </div>

                <?php if ($cb_userRol === 'psicologo'): ?>
                <div class="mb-6 text-left">
                    <label class="block text-sm font-semibold text-slate-700 dark:text-slate-200 mb-2">Explique por qué no puede asistir a esta cita <span class="text-red-500">*</span></label>
                    <textarea id="cbMotivoCancelacion" rows="3" class="w-full bg-white border-2 border-slate-200 dark:bg-slate-800 dark:border-slate-600 rounded-xl px-4 py-3 text-slate-700 dark:text-slate-100 text-sm focus:outline-none focus:border-red-400 dark:focus:border-red-500 transition-colors resize-none" placeholder="El paciente verá esta justificación..."></textarea>
                    <p id="cbErrorMotivoCancelacion" class="hidden text-xs text-red-500 mt-1">Debe ingresar un motivo para cancelar.</p>
                </div>
                <?php endif; ?>

                <div class="flex flex-col gap-3">
                    <button onclick="cbConfirmarCancelacion()" id="cbBtnCancelar"
                        class="w-full py-3 bg-red-500 text-white font-semibold rounded-xl hover:bg-red-600 transition-colors shadow-sm">
                        Sí, cancelar cita
                    </button>
                    <button onclick="cbGoToStep(5)" class="w-full py-3 bg-slate-100 hover:bg-slate-200 text-slate-700 dark:bg-slate-800 dark:hover:bg-slate-700 dark:text-slate-200 font-semibold rounded-xl transition-colors">
                        Volver
                    </button>
                </div>
            </div>
        </div>


        <!-- ══════════════ LOADING OVERLAY ══════════════ -->
        <div id="cbLoading" class="hidden absolute inset-0 bg-white/80 dark:bg-slate-900/80 backdrop-blur-sm rounded-t-[32px] flex items-center justify-center z-20">
            <div class="flex flex-col items-center gap-3">
                <div class="w-10 h-10 border-4 border-blue-200 border-t-blue-500 rounded-full animate-spin"></div>
                <p class="text-sm text-slate-500 dark:text-slate-400 font-medium">Consultando disponibilidad...</p>
            </div>
        </div>
    </div>
</div>

<!-- ══════════════ MODAL DE ÉXITO EXTERNO ══════════════ -->
<div id="successCitaModal" class="fixed inset-0 z-[60] hidden items-center justify-center" role="dialog" aria-modal="true">
    <div class="absolute inset-0 bg-black/40 backdrop-blur-sm" onclick="closeSuccessCitaModal()"></div>
    <div class="relative bg-white dark:bg-slate-800 rounded-3xl shadow-2xl p-8 max-w-sm w-full mx-4 transform scale-95 transition-transform duration-300 z-10 text-center">
        <div class="w-20 h-20 rounded-full bg-green-100 flex items-center justify-center mx-auto mb-5">
            <span class="material-symbols-outlined text-green-500 text-[44px]">check_circle</span>
        </div>
        <h3 class="text-2xl font-bold text-slate-800 dark:text-slate-100 mb-2">¡Cita creada con éxito!</h3>
        <p class="text-slate-500 dark:text-slate-400 mb-6">Hemos registrado tu cita correctamente.</p>
        <button onclick="closeSuccessCitaModal()" class="w-full py-3 bg-gradient-to-r from-blue-600 to-blue-700 text-white font-semibold rounded-xl hover:from-blue-700 hover:to-blue-800 transition-all active:scale-[0.98] shadow-md shadow-blue-100">
            Aceptar
        </button>
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
    idCitaEditar: null
};

const cbCitasPendientes = <?= $cb_citasPendientesJSON ?>;
const cbUserRol = '<?= $cb_userRol ?>';
let cbCancelId = null;

// ─── Navegación ───────────────────────────────────────────────────────
function openChatbotModal() {
    const m = document.getElementById('chatbotModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    cbReset(); // Reiniciar estado al abrir
}

function closeChatbotModal() {
    const m = document.getElementById('chatbotModal');
    m.classList.add('hidden');
    m.classList.remove('flex');
    document.body.style.overflow = '';
}

function openSuccessCitaModal() {
    const m = document.getElementById('successCitaModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    // Pequeño efecto de entrada
    setTimeout(() => {
        m.querySelector('.relative').classList.remove('scale-95');
        m.querySelector('.relative').classList.add('scale-100');
    }, 10);
}

function closeSuccessCitaModal() {
    const m = document.getElementById('successCitaModal');
    m.classList.add('hidden');
    m.classList.remove('flex');
    m.querySelector('.relative').classList.remove('scale-100');
    m.querySelector('.relative').classList.add('scale-95');
}

// ─── Agendamiento Directo (Desde Calendario) ─────────────────────────
function openChatbotForPsicologo(fecha, idPsicologo, nombrePsicologo) {
    const m = document.getElementById('chatbotModal');
    m.classList.remove('hidden');
    m.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    cbReset(); // Limpiar estado anterior
    
    CB.fecha = fecha;
    const fechaInput = document.getElementById('cbFecha');
    if (fechaInput) fechaInput.value = fecha;
    
    // Saltamos al paso 2 (Seleccionar Hora para este psicólogo)
    cbSeleccionarPsicologo(idPsicologo, nombrePsicologo);
}

function cbGoToStep(n) {
    document.querySelectorAll('.cb-step').forEach(el => el.classList.add('hidden'));
    document.getElementById('cbStep' + n).classList.remove('hidden');
}

function cbGoToStep1() { 
    CB.idCitaEditar = null; // Si entra por agendar, limpiamos edit
    cbGoToStep(1); 
}

// ─── Cancelar y Reprogramar ───────────────────────────────────────────
function cbGoToCancelList() {
    cbRenderCitasPendientes('cancelar');
    cbGoToStep(5);
}

function cbGoToReprogramList() {
    cbRenderCitasPendientes('reprogramar');
    cbGoToStep(5);
}

function cbRenderCitasPendientes(accion) {
    const container = document.getElementById('cbCitasPendientesList');
    document.getElementById('cbStep5Title').textContent = accion === 'cancelar' ? 'Cancelar Cita' : 'Reprogramar Cita';
    document.getElementById('cbStep5Subtitle').textContent = 'Selecciona la cita que deseas ' + accion;
    
    if (cbCitasPendientes.length === 0) {
        container.innerHTML = `
            <div class="text-center py-8">
                <div class="w-16 h-16 rounded-full bg-slate-50 dark:bg-slate-800/50 flex items-center justify-center mx-auto mb-3">
                    <span class="material-symbols-outlined text-[32px] text-slate-300 dark:text-slate-500">event_busy</span>
                </div>
                <p class="text-slate-600 dark:text-slate-300 font-medium">No tienes citas pendientes</p>
                <p class="text-slate-400 dark:text-slate-500 text-sm mt-1">Actualmente no hay citas próximas para ${accion}.</p>
            </div>
        `;
        return;
    }

    container.innerHTML = cbCitasPendientes.map(c => `
        <button onclick="${accion === 'cancelar' ? `cbPrepararCancelacion(${c.id_cita})` : `cbPrepararReprogramacion(${c.id_cita})`}" 
            class="w-full text-left p-4 bg-white border-2 border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50/40 dark:hover:bg-blue-900/30 transition-all active:scale-[0.98] group flex items-start gap-4">
            <div class="w-10 h-10 rounded-full bg-slate-100 dark:bg-slate-700/50 flex items-center justify-center shrink-0">
                <span class="material-symbols-outlined text-slate-500 dark:text-slate-400 group-hover:text-blue-500 dark:group-hover:text-blue-400">event</span>
            </div>
            <div class="flex-1 min-w-0">
                <p class="font-bold text-slate-800 dark:text-slate-100 text-sm mb-1">${c.fecha} a las ${c.hora}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">${cbUserRol === 'psicologo' ? 'Paciente: ' + c.paciente_nombre : 'Psic. ' + c.psicologo_nombre}</p>
            </div>
        </button>
    `).join('');
}

function cbPrepararCancelacion(idCita) {
    cbCancelId = idCita;
    const c = cbCitasPendientes.find(x => x.id_cita === idCita);
    document.getElementById('cbCancelResumen').innerHTML = `
        <div class="flex justify-between text-sm">
            <span class="text-slate-500 dark:text-slate-400">${cbUserRol === 'psicologo' ? 'Paciente' : 'Psicólogo'}:</span>
            <span class="font-bold text-slate-800 dark:text-slate-100 text-right">${cbUserRol === 'psicologo' ? c.paciente_nombre : c.psicologo_nombre}</span>
        </div>
        <div class="flex justify-between text-sm">
            <span class="text-slate-500 dark:text-slate-400">Fecha:</span>
            <span class="font-bold text-slate-800 dark:text-slate-100 text-right">${c.fecha}</span>
        </div>
        <div class="flex justify-between text-sm">
            <span class="text-slate-500 dark:text-slate-400">Hora:</span>
            <span class="font-bold text-slate-800 dark:text-slate-100 text-right">${c.hora}</span>
        </div>
    `;
    
    if (cbUserRol === 'psicologo') {
        document.getElementById('cbMotivoCancelacion').value = '';
        document.getElementById('cbErrorMotivoCancelacion').classList.add('hidden');
    }
    
    cbGoToStep(6);
}

async function cbConfirmarCancelacion() {
    if (!cbCancelId) return;
    
    let motivoCancelacion = '';
    if (cbUserRol === 'psicologo') {
        motivoCancelacion = document.getElementById('cbMotivoCancelacion').value.trim();
        if (!motivoCancelacion) {
            document.getElementById('cbErrorMotivoCancelacion').classList.remove('hidden');
            return;
        }
        document.getElementById('cbErrorMotivoCancelacion').classList.add('hidden');
    }
    
    cbShowLoading(true);
    try {
        const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
        const endpoint = cbUserRol === 'psicologo' ? 'citas/cancelarPsicologa' : 'citas/cancelar';
        const res = await fetch(BASE + endpoint, {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({ id_cita: cbCancelId, motivo: motivoCancelacion })
        });
        const data = await res.json();
        if (!data.ok) throw new Error(data.error);
        
        cbShowLoading(false);
        closeChatbotModal();
        
        const m = document.getElementById('successCitaModal');
        m.querySelector('h3').textContent = '¡Cita cancelada!';
        m.querySelector('p').textContent = 'Tu cita ha sido cancelada exitosamente.';
        openSuccessCitaModal();
        
        setTimeout(() => location.reload(), 1500);
        
    } catch (e) {
        cbShowLoading(false);
        alert('Error: ' + e.message);
    }
}

function cbPrepararReprogramacion(idCita) {
    CB.idCitaEditar = idCita;
    cbGoToStep(1);
}

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
            class="w-full flex items-center gap-4 p-4 bg-white border-2 border-slate-100 dark:bg-slate-800 dark:border-slate-700 rounded-2xl hover:border-blue-300 dark:hover:border-blue-500 hover:bg-blue-50/30 dark:hover:bg-blue-900/30 transition-all active:scale-[0.99] text-left group">
            <img src="${escHtml(p.foto_perfil)}" alt="${escHtml(p.nombre)}"
                class="w-12 h-12 rounded-xl object-cover shrink-0 ring-2 ring-blue-100 dark:ring-blue-900/50 group-hover:ring-blue-300 transition-all">
            <div class="flex-1 min-w-0">
                <p class="font-semibold text-slate-800 dark:text-slate-100 truncate">${escHtml(p.nombre)}</p>
                <p class="text-xs text-slate-500 dark:text-slate-400 truncate">${escHtml(p.especialidad)}</p>
            </div>
            <span class="material-symbols-outlined text-slate-300 dark:text-slate-600 group-hover:text-blue-400 transition-colors">chevron_right</span>
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
            <div class="col-span-3 text-center py-6 text-slate-400 dark:text-slate-500">
                <span class="material-symbols-outlined text-[40px] block mb-2">event_busy</span>
                <p class="text-sm">No hay horas disponibles este día para este psicólogo.</p>
            </div>`;
        return;
    }

    container.innerHTML = horas.map(h => `
        <button onclick="cbSeleccionarHora('${h}', this)"
            data-hora="${h}"
            class="hora-btn py-2.5 px-3 border-2 border-slate-200 dark:border-slate-700 rounded-xl text-sm font-semibold text-slate-600 dark:text-slate-300 hover:border-blue-400 dark:hover:border-blue-500 hover:bg-blue-50 dark:hover:bg-blue-900/30 hover:text-blue-600 dark:hover:text-blue-400 transition-all active:scale-[0.97]">
            ${h}
        </button>
    `).join('');
}

function cbSeleccionarHora(hora, btn) {
    // Quitar selección anterior
    document.querySelectorAll('.hora-btn').forEach(b => {
        b.classList.remove('border-blue-500', 'bg-blue-500', 'text-white', 'dark:border-blue-500', 'dark:bg-blue-500', 'dark:text-white', 'hover:text-blue-600', 'dark:hover:text-blue-400');
        b.classList.add('border-slate-200', 'text-slate-600', 'dark:border-slate-700', 'dark:text-slate-300', 'hover:text-blue-600', 'dark:hover:text-blue-400');
    });
    // Marcar seleccionada
    btn.classList.remove('border-slate-200', 'text-slate-600', 'dark:border-slate-700', 'dark:text-slate-300', 'hover:text-blue-600', 'dark:hover:text-blue-400');
    btn.classList.add('border-blue-500', 'bg-blue-500', 'text-white', 'dark:border-blue-500', 'dark:bg-blue-500', 'dark:text-white');

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
        
        let endpoint = 'chat_bot/guardarCita';
        let bodyData = {
            id_cita:          null,
            id_usuario:       null, 
            id_psicologo:     CB.psicologoId,
            fecha:            CB.fecha,
            hora:             CB.hora,
            estado:           'pendiente',
            motivo_consulta:  motivo,
            fecha_creacion:   new Date().toISOString().slice(0, 19).replace('T', ' ')
        };

        if (CB.idCitaEditar) {
            endpoint = 'citas/editar';
            bodyData = {
                id_cita: CB.idCitaEditar,
                fecha: CB.fecha,
                hora: CB.hora,
                id_psicologo: CB.psicologoId
            };
        }

        const res  = await fetch(BASE + endpoint, {
            method:  'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify(bodyData)
        });
        const data = await res.json();

        if (!data.ok) throw new Error(data.error || 'Error al guardar');

        cbShowLoading(false);
        closeChatbotModal();

        const m = document.getElementById('successCitaModal');
        if (CB.idCitaEditar) {
            m.querySelector('h3').textContent = '¡Cita reprogramada!';
            m.querySelector('p').textContent = 'Tu cita ha sido reprogramada exitosamente.';
        } else {
            m.querySelector('h3').textContent = '¡Cita agendada!';
            m.querySelector('p').textContent = 'Hemos registrado tu cita correctamente.';
        }
        openSuccessCitaModal();

        if (CB.idCitaEditar) {
            setTimeout(() => location.reload(), 1500);
        }
    } catch (e) {
        cbShowLoading(false);
        errMsg.textContent = e.message;
        errEl.classList.remove('hidden');
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

// ─── Terminar Cita en proceso ─────────────────────────────────────────
async function cbTerminarCita(id_cita, duracion_minutos, notas_sesion) {
    try {
        const BASE = window.URL_BASE || (window.location.origin + '/psyco_proyecto-davidBackend1/');
        const res = await fetch(BASE + 'chat_bot/terminarCita', {
            method: 'POST',
            headers: { 'Content-Type': 'application/json' },
            body: JSON.stringify({
                id_cita: id_cita,
                duracion_minutos: duracion_minutos,
                notas_sesion: notas_sesion
            })
        });
        const data = await res.json();
        if (data.ok) {
            console.log('Cita terminada con éxito:', data.mensaje);
            // Lógica adicional para actualizar UI si es necesario
        } else {
            console.error('Error al terminar cita:', data.error);
        }
    } catch (e) {
        console.error('Excepción al terminar cita:', e);
    }
}
</script>
