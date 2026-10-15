<style>
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
    background: rgba(244, 247, 246, 0.65);
    pointer-events: none;
    z-index: 0;
}
.dark #main-content::before { 
    background: rgba(15, 23, 42, 0.78); 
}
</style>

<!-- ═══════════════════════════════════════════════════════════
     TÉRMINOS Y CONDICIONES DE USO Y POLÍTICA DE HABEAS DATA
     Conforme a la Constitución Política de Colombia y Ley 1581 de 2012
     ═══════════════════════════════════════════════════════════ -->
<div class="relative z-10 max-w-4xl mx-auto py-8 sm:py-12 px-4 sm:px-6">
    <div class="bg-white/95 dark:bg-slate-900/95 backdrop-blur-md rounded-3xl shadow-2xl border border-slate-200/80 dark:border-slate-800 overflow-hidden transition-colors">
        
        <!-- Header Principal -->
        <div class="border-b border-slate-100 dark:border-slate-800 pt-8 pb-7 px-6 sm:px-10 bg-gradient-to-r from-emerald-50/80 via-teal-50/50 to-white dark:from-emerald-950/30 dark:via-slate-900 dark:to-slate-900">
            <div class="flex items-center gap-4 mb-2">
                <div class="w-12 h-12 rounded-2xl bg-gradient-to-br from-emerald-600 to-teal-700 text-white flex items-center justify-center shadow-md shadow-emerald-600/25 shrink-0">
                    <span class="material-symbols-outlined text-[28px]">gavel</span>
                </div>
                <div>
                    <h1 class="text-2xl sm:text-3xl font-extrabold text-slate-900 dark:text-white leading-tight">
                        Términos y Condiciones de Uso
                    </h1>
                    <p class="text-xs sm:text-sm font-semibold text-emerald-700 dark:text-emerald-400 mt-1">
                        Política de Tratamiento de Datos Personales (Habeas Data) y Acompañamiento Psicológico Digital
                    </p>
                </div>
            </div>
            <div class="mt-4 flex flex-wrap gap-2 text-xs">
                <span class="px-2.5 py-1 rounded-full bg-emerald-100 dark:bg-emerald-900/40 text-emerald-800 dark:text-emerald-300 font-medium">
                    Constitución Política de Colombia (Arts. 15, 16, 74)
                </span>
                <span class="px-2.5 py-1 rounded-full bg-blue-100 dark:bg-blue-900/40 text-blue-800 dark:text-blue-300 font-medium">
                    Ley Estatutaria 1581 de 2012
                </span>
                <span class="px-2.5 py-1 rounded-full bg-purple-100 dark:bg-purple-900/40 text-purple-800 dark:text-purple-300 font-medium">
                    Ley 1090 de 2006 (Código Deontológico)
                </span>
            </div>
        </div>

        <!-- Content Body -->
        <div class="p-6 sm:p-10 space-y-8 text-slate-700 dark:text-slate-300 text-sm sm:text-base leading-relaxed">
            
            <!-- Declaración de Aceptación -->
            <div class="bg-slate-50 dark:bg-slate-800/60 border border-slate-200 dark:border-slate-700 rounded-2xl p-5 sm:p-6 shadow-sm">
                <div class="flex items-start gap-3">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[26px] shrink-0 mt-0.5">verified_user</span>
                    <div>
                        <h2 class="text-base sm:text-lg font-bold text-slate-900 dark:text-white mb-1">
                            Consentimiento Previo, Expreso e Informado
                        </h2>
                        <p class="text-slate-600 dark:text-slate-300 text-sm sm:text-base">
                            Al registrarte, iniciar sesión o marcar la casilla de aceptación en nuestra plataforma, manifiestas de forma libre, voluntaria, informada e inequívoca que <strong>conoces, entiendes y aceptas en su integridad los presentes Términos y Condiciones</strong>, así como el tratamiento de tus datos personales para las finalidades exclusivas de orientación y acompañamiento psicológico descritas a continuación.
                        </p>
                    </div>
                </div>
            </div>

            <!-- Punto 1: Marco Legal Colombiano y Naturaleza del Servicio -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5 text-slate-900 dark:text-white font-bold text-lg">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[24px]">balance</span>
                    <h2>1. Marco Constitucional y Legal</h2>
                </div>
                <p>
                    El tratamiento de la información en este entorno digital se rige por los estatutos legales vigentes de la República de Colombia:
                </p>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-3 pt-1">
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700/60">
                        <strong class="text-slate-900 dark:text-slate-100 flex items-center gap-1.5 mb-1 text-sm font-bold">
                            <span class="material-symbols-outlined text-[18px] text-emerald-600 dark:text-emerald-400">shield</span>
                            Habeas Data (Art. 15 Const. y Ley 1581/2012)
                        </strong>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                            Garantiza tu derecho constitucional a conocer, actualizar, rectificar y suprimir cualquier información personal recogida en bases de datos.
                        </p>
                    </div>
                    <div class="p-4 rounded-xl bg-slate-50 dark:bg-slate-800/40 border border-slate-200/80 dark:border-slate-700/60">
                        <strong class="text-slate-900 dark:text-slate-100 flex items-center gap-1.5 mb-1 text-sm font-bold">
                            <span class="material-symbols-outlined text-[18px] text-teal-600 dark:text-teal-400">lock</span>
                            Secreto Profesional (Art. 74 Const. y Ley 1090/2006)
                        </strong>
                        <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-400">
                            El secreto profesional es inviolable. La información compartida con los profesionales de la psicología está amparada por estricta reserva legal y ética.
                        </p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 dark:border-slate-800" />

            <!-- Punto 2: Cómo funciona el Sitio Web y qué se recopila -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 text-slate-900 dark:text-white font-bold text-lg">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[24px]">devices</span>
                    <h2>2. ¿Cómo funciona la Plataforma y qué Datos se Recopilan?</h2>
                </div>
                <p>
                    La plataforma es un sistema digital diseñado exclusivamente para facilitar el agendamiento y la gestión de citas de orientación y acompañamiento psicológico, así como el acceso a recursos psicoeducativos. Para su correcto funcionamiento, se recopilan:
                </p>
                <ul class="space-y-3 pl-1 text-sm sm:text-base">
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[20px] shrink-0 mt-0.5">badge</span>
                        <div>
                            <strong class="text-slate-900 dark:text-slate-100">Datos de Identificación y Contacto:</strong>
                            Nombre completo, correo electrónico, rol de usuario y contraseña protegida (o vinculación mediante autenticación segura con Google OAuth).
                        </div>
                    </li>
                    <li class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[20px] shrink-0 mt-0.5">psychology</span>
                        <div>
                            <strong class="text-slate-900 dark:text-slate-100">Datos Sensibles de Salud Mental (Motivo de Consulta y Citas):</strong>
                            Fecha, hora, motivo o descripción voluntaria del acompañamiento solicitado, y notas privadas generadas por el profesional asignado. En los términos del artículo 5 y 6 de la Ley 1581 de 2012, se te informa que <em>no estás obligado a suministrar datos sensibles</em> salvo que sean indispensables para la orientación psicológica solicitada.
                        </div>
                    </li>
                </ul>
            </div>

            <hr class="border-slate-100 dark:border-slate-800" />

            <!-- Punto 3: Qué ocurre con tus datos y Cifrado de Seguridad -->
            <div class="space-y-4">
                <div class="flex items-center gap-2.5 text-slate-900 dark:text-white font-bold text-lg">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[24px]">enhanced_encryption</span>
                    <h2>3. ¿Qué Ocurre con tus Datos y cómo se Protegen?</h2>
                </div>
                <div class="space-y-3">
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[20px] shrink-0 mt-0.5">check_circle</span>
                        <p>
                            <strong class="text-slate-900 dark:text-slate-100">Cifrado Criptográfico Fuerte:</strong> Todos los motivos de consulta, notas de evolución y contenidos sensibles son almacenados en la base de datos de manera encriptada utilizando algoritmos criptográficos robustos de grado bancario (AES-256). Las contraseñas están irreversiblemente procesadas con funciones hash de última generación (Argon2id / Bcrypt).
                        </p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[20px] shrink-0 mt-0.5">check_circle</span>
                        <p>
                            <strong class="text-slate-900 dark:text-slate-100">Finalidad Exclusiva:</strong> Tus datos se emplean única y exclusivamente para: (i) la confirmación y agenda de tus turnos, (ii) el contacto por parte del profesional asignado, (iii) el envío automatizado de recordatorios para tu sesión, y (iv) el debido seguimiento profesional.
                        </p>
                    </div>
                    <div class="flex items-start gap-3">
                        <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[20px] shrink-0 mt-0.5">check_circle</span>
                        <p>
                            <strong class="text-slate-900 dark:text-slate-100">Cero Comercialización y Cero Terceros:</strong> Bajo ningún motivo o circunstancia la información personal o clínica de los usuarios será vendida, cedida, compartida ni transferida a agencias publicitarias, entidades comerciales ni terceros ajenos al servicio institucional de psicología.
                        </p>
                    </div>
                </div>
            </div>

            <hr class="border-slate-100 dark:border-slate-800" />

            <!-- Punto 4: Aislamiento Técnico y Conocimiento Cero -->
            <div class="space-y-3 bg-emerald-50/60 dark:bg-emerald-950/20 border border-emerald-200/80 dark:border-emerald-800/40 rounded-2xl p-5 sm:p-6">
                <div class="flex items-center gap-2.5 text-emerald-900 dark:text-emerald-300 font-bold text-lg">
                    <span class="material-symbols-outlined text-emerald-700 dark:text-emerald-400 text-[24px]">visibility_off</span>
                    <h2>4. Privacidad por Diseño: Aislamiento Técnico y Custodia Exclusiva</h2>
                </div>
                <p class="text-emerald-950 dark:text-emerald-200">
                    La arquitectura de este software está fundamentada en el principio técnico de <strong>Conocimiento Cero (Zero-Knowledge)</strong> y estricta separación de funciones:
                </p>
                <ul class="space-y-2.5 text-xs sm:text-sm text-emerald-900/90 dark:text-emerald-200/90 pl-1">
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">lock_person</span>
                        <span>
                            <strong>Acceso exclusivo del profesional en psicología:</strong> Únicamente el profesional tratante asignado posee los permisos y credenciales de desencriptado para leer los motivos de consulta e historiales clínicos confidenciales de sus pacientes.
                        </span>
                    </li>
                    <li class="flex items-start gap-2">
                        <span class="material-symbols-outlined text-emerald-600 text-[18px] shrink-0 mt-0.5">no_accounts</span>
                        <span>
                            <strong>Inexistencia de acceso para personal técnico o de desarrollo:</strong> El personal informático, de soporte o de desarrollo de software <strong>NO tiene acceso, NO puede visualizar, NO lee, NO conoce ni almacena copia descifrada alguna</strong> sobre las consultas, notas médicas, motivos personales ni conversaciones del usuario. Los datos residen cifrados y son inaccesibles para cualquier rol técnico.
                        </span>
                    </li>
                </ul>
            </div>

            <hr class="border-slate-100 dark:border-slate-800" />

            <!-- Punto 5: Chatbot y Acceso Rápido -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5 text-slate-900 dark:text-white font-bold text-lg">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[24px]">smart_toy</span>
                    <h2>5. Funcionamiento del Chatbot / Acceso Rápido</h2>
                </div>
                <p>
                    La plataforma incorpora una herramienta interactiva automatizada (Chatbot) diseñada para agilizar el agendamiento y suministrar orientación general e información sobre recursos de bienestar.
                </p>
                <div class="p-4 rounded-xl bg-amber-50/80 dark:bg-amber-950/20 border border-amber-200 dark:border-amber-800/40 text-amber-950 dark:text-amber-200 text-xs sm:text-sm">
                    <strong>Aviso importante:</strong> Las respuestas y sugerencias del chatbot constituyen una guía informativa de apoyo preliminar. <u>En ningún caso reemplazan la consulta médica, el diagnóstico psicológico ni el proceso psicoterapéutico profesional</u> que debe ser realizado directamente con la psicóloga.
                </div>
            </div>

            <hr class="border-slate-100 dark:border-slate-800" />

            <!-- Punto 6: Excepción al Secreto Profesional - Protección de la Vida -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5 text-rose-700 dark:text-rose-400 font-bold text-lg">
                    <span class="material-symbols-outlined text-rose-600 dark:text-rose-400 text-[24px]">health_and_safety</span>
                    <h2>6. Excepción al Secreto Profesional: Protección de la Vida y Protocolo de Emergencia</h2>
                </div>
                <div class="p-5 rounded-2xl bg-rose-50/80 dark:bg-rose-950/20 border border-rose-200 dark:border-rose-900/40 text-rose-950 dark:text-rose-200 space-y-2.5">
                    <p class="font-bold text-sm sm:text-base">
                        Prevalencia constitucional del Derecho Fundamental a la Vida (Artículo 11 de la Constitución Política de Colombia):
                    </p>
                    <p class="text-xs sm:text-sm leading-relaxed">
                        Conforme al Código Deontológico de la Psicología (Ley 1090 de 2006, Art. 2 numeral 5 y Art. 25), la reserva profesional solo podrá levantarse en caso de <strong>peligro inminente y grave para la vida o la integridad física</strong> del paciente (riesgo o ideación suicida) o de terceros. En dicho evento excepcional, la profesional tratante está facultada y obligada legalmente a romper la confidencialidad para contactar a acudientes, instituciones de apoyo y servicios de salud médica de urgencia.
                    </p>
                </div>
            </div>

            <hr class="border-slate-100 dark:border-slate-800" />

            <!-- Punto 7: Menores de Edad y Consentimiento de Acudientes -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5 text-slate-900 dark:text-white font-bold text-lg">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[24px]">family_restroom</span>
                    <h2>7. Usuarios Menores de Edad y Autorización de Padres o Representantes</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                    En concordancia con el Código de la Infancia y la Adolescencia (Ley 1098 de 2006) y el artículo 12 del Decreto 1377 de 2013, cuando el usuario sea menor de edad, el registro y uso de la plataforma presupone y exige que cuenta con la <strong>autorización previa, conocimiento y acompañamiento de sus padres o representantes legales</strong>. La institución educativa se reserva el derecho de validar el consentimiento informado correspondiente según los protocolos escolares.
                </p>
            </div>

            <hr class="border-slate-100 dark:border-slate-800" />

            <!-- Punto 8: Ejercicio de Derechos Habeas Data (ARCO) -->
            <div class="space-y-3">
                <div class="flex items-center gap-2.5 text-slate-900 dark:text-white font-bold text-lg">
                    <span class="material-symbols-outlined text-emerald-600 dark:text-emerald-400 text-[24px]">contact_support</span>
                    <h2>8. Canales para el Ejercicio de tus Derechos (ARCO)</h2>
                </div>
                <p class="text-xs sm:text-sm text-slate-600 dark:text-slate-300">
                    En cualquier momento, como titular de los datos personales tienes derecho a:
                </p>
                <div class="grid grid-cols-2 sm:grid-cols-4 gap-2 text-center text-xs font-semibold">
                    <div class="p-2.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                        Acceder y Conocer
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                        Actualizar
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                        Rectificar
                    </div>
                    <div class="p-2.5 rounded-lg bg-slate-100 dark:bg-slate-800 text-slate-800 dark:text-slate-200">
                        Suprimir / Revocar*
                    </div>
                </div>
                <p class="text-[11px] sm:text-xs text-slate-500 dark:text-slate-400 italic">
                    * La supresión de datos estará sujeta a los deberes legales de conservación documental y custodia de historias clínicas fijados por el Ministerio de Salud y Protección Social (Resolución 1995 de 1999 y Resolución 839 de 2017). Para ejercer tus derechos puedes acudir al área de Orientación y Psicología de la institución.
                </p>
            </div>

        </div>

        <!-- Footer Actions -->
        <div class="border-t border-slate-100 dark:border-slate-800 p-6 sm:px-10 bg-slate-50 dark:bg-slate-900/80 flex items-center justify-between flex-wrap gap-4">
            <span class="text-xs text-slate-500 dark:text-slate-400">
                Última actualización: Octubre de 2026 • República de Colombia
            </span>
            <a href="javascript:history.back()"
               class="px-6 py-2.5 rounded-xl border border-slate-300 dark:border-slate-700 text-slate-700 dark:text-slate-300 font-semibold text-sm hover:bg-slate-100 dark:hover:bg-slate-800 transition-colors flex items-center gap-2 cursor-pointer shadow-sm">
                <span class="material-symbols-outlined text-[18px]">arrow_back</span>
                Volver
            </a>
        </div>
    </div>
</div>

