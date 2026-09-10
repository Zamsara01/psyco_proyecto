<!-- ═══════════════════════════════════════════════════════════
     MODAL DE TÉRMINOS Y CONDICIONES DE USO
     Institución Educativa Barrio Santa Margarita (Medellín)
     Se abre con: openTermsModal(event)
     ═══════════════════════════════════════════════════════════ -->

<div id="termsModal"
     class="fixed inset-0 z-[90] hidden items-center justify-center p-4 sm:p-6"
     role="dialog" aria-modal="true" aria-labelledby="termsModalTitle">

    <!-- Backdrop -->
    <div id="termsModalBackdrop"
         class="absolute inset-0 bg-slate-900/60 backdrop-blur-sm transition-opacity duration-300"
         onclick="closeTermsModal()"></div>

    <!-- Card Container -->
    <div id="termsModalCard"
         class="relative z-10 w-full max-w-2xl bg-white rounded-3xl shadow-2xl border border-slate-100 
                transform scale-95 opacity-0 transition-all duration-200 ease-out flex flex-col max-h-[85vh] overflow-hidden">

        <!-- Header -->
        <div class="flex-shrink-0 relative border-b border-slate-100 pt-6 pb-4 px-6 sm:px-8 bg-gradient-to-r from-emerald-50 via-teal-50 to-white">
            <button onclick="closeTermsModal()"
                    class="absolute top-5 right-5 p-2 rounded-full text-slate-400 hover:bg-slate-200/60 hover:text-slate-700 transition-colors focus:outline-none"
                    aria-label="Cerrar">
                <span class="material-symbols-outlined text-[22px]">close</span>
            </button>

            <div class="flex items-center gap-3 mb-2">
                <div class="w-10 h-10 rounded-xl bg-emerald-600 text-white flex items-center justify-center shadow-md shadow-emerald-600/20">
                    <span class="material-symbols-outlined text-[24px]">gavel</span>
                </div>
                <div>
                    <h2 id="termsModalTitle" class="text-xl sm:text-2xl font-bold text-slate-900 leading-tight">
                        Términos y Condiciones de Uso
                    </h2>
                    <p class="text-xs sm:text-sm font-medium text-emerald-700">
                        Plataforma de Gestión de Citas Psicológicas – I.E. Barrio Santa Margarita (Medellín)
                    </p>
                </div>
            </div>
        </div>

        <!-- Scrollable Content Body -->
        <div class="flex-grow overflow-y-auto p-6 sm:p-8 space-y-6 text-slate-700 text-sm leading-relaxed">

            <!-- Bienvenida e Intro -->
            <div class="bg-slate-50 border border-slate-200/80 rounded-2xl p-4 sm:p-5">
                <p class="font-medium text-slate-800">
                    Bienvenido a nuestra plataforma. Este software ha sido desarrollado por estudiantes de grado 11 con fines académicos y de servicio institucional. Al registrarte, iniciar sesión y marcar la casilla de aceptación, declaras que conoces, entiendes y aceptas obligatoriamente la totalidad de los términos descritos a continuación.
                </p>
            </div>

            <!-- Punto 1: Roles y Accesos -->
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-slate-900 font-bold text-base">
                    <span class="material-symbols-outlined text-emerald-600 text-[20px]">manage_accounts</span>
                    <h3>1. Roles y Accesos a la Plataforma</h3>
                </div>
                <p class="text-slate-600">
                    Para garantizar la seguridad de la información, el sistema opera bajo tres roles estrictamente limitados:
                </p>
                <ul class="space-y-2.5 pl-2">
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <div>
                            <strong class="text-slate-900">Usuarios (Estudiantes y Padres):</strong> Tienen acceso a su perfil, agenda de citas y al chatbot interactivo.
                        </div>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <div>
                            <strong class="text-slate-900">Administradoras (Psicólogas del Instituto):</strong> Son las únicas personas autorizadas para acceder a la información privada de los estudiantes, motivos de consulta e historial clínico.
                        </div>
                    </li>
                    <li class="flex items-start gap-2.5">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">check_circle</span>
                        <div>
                            <strong class="text-slate-900">Equipo Desarrollador (Estudiantes de Grado 11):</strong> Creadores del software. Se establece explícitamente que el equipo desarrollador <span class="underline decoration-emerald-500 font-semibold text-slate-900">NO tiene ni tendrá acceso bajo ninguna circunstancia</span> a las historias clínicas, conversaciones privadas ni datos confidenciales de los pacientes. Su rol se limita estrictamente al soporte técnico y mantenimiento de la plataforma.
                        </div>
                    </li>
                </ul>
            </div>

            <hr class="border-slate-100" />

            <!-- Punto 2: Chatbot y Consejería -->
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-slate-900 font-bold text-base">
                    <span class="material-symbols-outlined text-emerald-600 text-[20px]">smart_toy</span>
                    <h3>2. Funcionamiento del Chatbot y Consejería</h3>
                </div>
                <p class="text-slate-600">
                    La plataforma cuenta con un chatbot automatizado diseñado para interactuar con los estudiantes, escuchar sus intereses y ofrecer consejos de orientación general.
                </p>
                <div class="bg-emerald-50/70 border border-emerald-200/70 rounded-xl p-4 text-emerald-900">
                    <p class="text-xs sm:text-sm">
                        • El usuario entiende que el chatbot es una herramienta de apoyo impulsada por inteligencia artificial y que sus respuestas automáticas <strong class="font-bold">no reemplazan el criterio, diagnóstico ni la terapia formal</strong> que imparte una psicóloga profesional de forma presencial.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100" />

            <!-- Punto 3: Protocolo de Emergencia -->
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-rose-700 font-bold text-base">
                    <span class="material-symbols-outlined text-rose-600 text-[20px]">e911_emergency</span>
                    <h3>3. Activación de Protocolo de Emergencia (Protección de la Vida)</h3>
                </div>
                <div class="bg-rose-50 border border-rose-200 rounded-2xl p-4 space-y-2 text-rose-950">
                    <p class="font-bold text-rose-800 text-sm">
                        La privacidad de los datos es una prioridad, pero el derecho a la vida está por encima de todo.
                    </p>
                    <ul class="space-y-2 text-xs sm:text-sm text-rose-900">
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-rose-600 text-[18px] shrink-0 mt-0.5">warning</span>
                            <div>
                                <strong>Caso de Emergencia Extrema:</strong> Si a través del chatbot, de los mensajes de texto o durante el agendamiento de citas se detecta que la vida o integridad física del paciente/usuario corre peligro inminente (por ejemplo, ideación o riesgo de suicidio), la psicóloga administradora queda totalmente facultada para romper la confidencialidad y activar de inmediato el Protocolo de Emergencia Institucional.
                            </div>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="material-symbols-outlined text-rose-600 text-[18px] shrink-0 mt-0.5">health_and_safety</span>
                            <div>
                                Esta activación permitirá al instituto contactar a los padres, acudientes o autoridades de salud correspondientes para brindar la ayuda médica urgente que el estudiante necesite.
                            </div>
                        </li>
                    </ul>
                </div>
            </div>

            <hr class="border-slate-100" />

            <!-- Punto 4: Limitación de Responsabilidad Tecnológica -->
            <div class="space-y-3">
                <div class="flex items-center gap-2 text-slate-900 font-bold text-base">
                    <span class="material-symbols-outlined text-emerald-600 text-[20px]">build_circle</span>
                    <h3>4. Limitación de Responsabilidad Tecnológica</h3>
                </div>
                <p class="text-slate-600">
                    Dado que este software es un proyecto escolar en desarrollo, los usuarios aceptan que la plataforma se proporciona "tal cual está". El instituto y el equipo desarrollador no se hacen responsables por fallas técnicas temporales, caídas del servidor o pérdida de turnos de citas debido a problemas de conexión a internet.
                </p>
            </div>

            <hr class="border-slate-200" />

            <!-- Consentimiento de los Acudientes -->
            <div class="bg-amber-50 border border-amber-200 rounded-2xl p-5 space-y-2">
                <div class="flex items-center gap-2 text-amber-900 font-bold text-sm sm:text-base">
                    <span class="material-symbols-outlined text-amber-600 text-[20px]">family_restroom</span>
                    <h4>Consentimiento de los Acudientes (Letra Pequeña Obligatoria)</h4>
                </div>
                <p class="text-xs sm:text-sm text-amber-900 leading-relaxed">
                    Al registrarse en esta plataforma, el usuario declara bajo gravedad de juramento que es mayor de 18 años o, en su defecto, que cuenta con la total autorización, supervisión y consentimiento de sus padres, representantes legales o acudientes para el uso de esta herramienta digital, la interacción con el chatbot y la gestión de sus citas psicológicas dentro de la Institución Educativa Barrio Santa Margarita. El colegio se reserva el derecho de verificar esta información con los registros de matrícula.
                </p>
            </div>

        </div>

        <!-- Footer Actions -->
        <div class="flex-shrink-0 border-t border-slate-100 p-4 sm:px-8 bg-slate-50 flex items-center justify-end gap-3">
            <button onclick="closeTermsModal()"
                    type="button"
                    class="px-5 py-2.5 rounded-xl border border-slate-300 text-slate-700 font-semibold text-sm hover:bg-slate-100 transition-colors">
                Cerrar
            </button>
            <button onclick="acceptTermsFromModal()"
                    type="button"
                    class="px-6 py-2.5 rounded-xl bg-emerald-600 text-white font-bold text-sm shadow-lg shadow-emerald-600/20 hover:bg-emerald-700 active:scale-[0.98] transition-all flex items-center gap-2">
                <span class="material-symbols-outlined text-[18px]">check</span>
                Entendido y Aceptar
            </button>
        </div>

    </div>
</div>

<script>
function openTermsModal(e) {
    if (e && e.preventDefault) e.preventDefault();
    const modal = document.getElementById('termsModal');
    const card  = document.getElementById('termsModalCard');
    if (!modal) return;
    
    modal.classList.remove('hidden');
    modal.classList.add('flex');
    document.body.style.overflow = 'hidden';
    
    setTimeout(() => {
        if (card) {
            card.classList.remove('scale-95', 'opacity-0');
            card.classList.add('scale-100', 'opacity-100');
        }
    }, 10);
}

function closeTermsModal() {
    const modal = document.getElementById('termsModal');
    const card  = document.getElementById('termsModalCard');
    if (!modal) return;
    
    if (card) {
        card.classList.remove('scale-100', 'opacity-100');
        card.classList.add('scale-95', 'opacity-0');
    }
    
    setTimeout(() => {
        modal.classList.add('hidden');
        modal.classList.remove('flex');
        document.body.style.overflow = '';
    }, 150);
}

function acceptTermsFromModal() {
    const checkboxes = document.querySelectorAll('input[type="checkbox"]#terms');
    checkboxes.forEach(cb => {
        cb.checked = true;
    });
    closeTermsModal();
}

document.addEventListener('keydown', function(e) {
    if (e.key === 'Escape') {
        const modal = document.getElementById('termsModal');
        if (modal && !modal.classList.contains('hidden')) {
            closeTermsModal();
        }
    }
});
</script>
