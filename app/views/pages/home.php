<!-- ═══════════════════════════════════════════════════════════
     PSYCO — Página de Inicio
     ═══════════════════════════════════════════════════════════ -->

<!-- ── Hero ──────────────────────────────────────────────────── -->
<section class="relative flex-grow flex items-center justify-center py-16 sm:py-24 px-6 overflow-hidden bg-gradient-to-br from-blue-600 to-emerald-500">

    <!-- Blobs decorativos adicionales para dar dinamismo -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[550px] h-[550px] rounded-full bg-white/10 blur-3xl"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[450px] h-[450px] rounded-full bg-emerald-400/20 blur-3xl"></div>
    </div>

    <div class="max-w-3xl mx-auto text-center relative z-10">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="<?= URL_BASE ?>public/img/psyco.png" alt="PSYCO Logo" class="h-32 sm:h-48 object-contain drop-shadow-2xl brightness-0 invert">
        </div>

        <!-- Título principal -->
        <h1 class="text-headline-md sm:text-headline-lg font-headline-md text-white mb-4 leading-tight drop-shadow-md">
            Un espacio seguro para escucharte en <span class="text-emerald-300 drop-shadow-sm">PSYCO</span>
        </h1>

        <!-- Subtítulo -->
        <p class="text-body-md sm:text-body-lg font-body-md text-white/90 max-w-xl mx-auto mb-10 leading-relaxed drop-shadow-sm">
            Nuestra plataforma escolar está diseñada para acompañarte cuando lo necesites. Conecta con tu psicóloga de forma segura y confidencial. Agenda tus citas y encuentra apoyo a tu ritmo, en un entorno de confianza.
        </p>

        <!-- CTAs -->
        <div class="flex flex-col sm:flex-row gap-3 justify-center">
            <?php 
            $rol = $_SESSION['user']['rol'] ?? null;
            if ($rol === 'paciente'): ?>
                <!-- Opciones para Paciente -->
                <button onclick="openChatbotModal()"
                   class="inline-flex items-center justify-center gap-2 h-12 px-8 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-200 hover:from-orange-600 hover:to-orange-700 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">smart_toy</span>
                    Gestionar Citas
                </button>
                <a href="<?= URL_BASE ?>citas/misCitas"
                   class="inline-flex items-center justify-center gap-2 h-12 px-6 border-2 border-orange-200 text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">event_note</span>
                    Mis Citas
                </a>
                <a href="<?= URL_BASE ?>citas/misRecursos"
                   class="inline-flex items-center justify-center gap-2 h-12 px-6 border-2 border-orange-200 text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">auto_stories</span>
                    Mis Recursos
                </a>
            <?php elseif ($rol === 'psicologo'): ?>
                <!-- Opciones para Psicóloga -->
                <a href="<?= URL_BASE ?>panel_psicologas"
                   class="inline-flex items-center justify-center gap-2 h-12 px-8 bg-gradient-to-r from-orange-500 to-orange-600 text-white font-bold rounded-xl shadow-lg shadow-orange-200 hover:from-orange-600 hover:to-orange-700 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    Ir a Mi Panel
                </a>
                <a href="<?= URL_BASE ?>calendario"
                   class="inline-flex items-center justify-center gap-2 h-12 px-6 border-2 border-orange-200 text-orange-600 font-bold rounded-xl hover:bg-orange-50 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    Calendario
                </a>
            <?php else: ?>
                <!-- Opciones para Invitado -->
                <button onclick="openRegisterModal()"
                   class="inline-flex items-center justify-center gap-2 h-12 px-8 bg-white text-blue-600 font-bold rounded-xl shadow-lg shadow-black/10 hover:bg-slate-50 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    Crear cuenta
                </button>
                <button onclick="openLoginModal()"
                   class="inline-flex items-center justify-center gap-2 h-12 px-8 border-2 border-white/80 text-white font-bold rounded-xl hover:bg-white/10 hover:border-white transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    Iniciar sesión
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ── Características ───────────────────────────────────────── -->
<section class="py-16 px-6 bg-gradient-to-b from-white to-blue-50/50">
    <div class="max-w-5xl mx-auto">

        <h2 class="text-headline-sm font-headline-md text-blue-900 text-center mb-10">¿Qué ofrece PSYCO?</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <!-- Tarjeta 1 -->
            <div class="bg-white rounded-2xl border border-blue-100 shadow-sm shadow-blue-100/50 p-6 flex flex-col items-center text-center gap-4 hover:shadow-md hover:border-blue-200 transition-all">
                <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-500 text-[36px]">calendar_month</span>
                </div>
                <h3 class="text-label-md font-label-md text-blue-900 uppercase tracking-wide">Agenda tu cita</h3>
                <p class="text-body-sm text-slate-600">Solicita una sesión con la psicóloga disponible en los horarios que mejor se adapten a ti.</p>
            </div>

            <!-- Tarjeta 2 -->
            <div class="bg-white rounded-2xl border border-emerald-100 shadow-sm shadow-emerald-100/50 p-6 flex flex-col items-center text-center gap-4 hover:shadow-md hover:border-emerald-200 transition-all">
                <div class="w-16 h-16 rounded-full bg-emerald-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-emerald-500 text-[36px]">chat_bubble</span>
                </div>
                <h3 class="text-label-md font-label-md text-emerald-900 uppercase tracking-wide">Chatbot de orientación</h3>
                <p class="text-body-sm text-slate-600">Nuestro asistente virtual te guía en el proceso y responde tus dudas de forma inmediata.</p>
            </div>

            <!-- Tarjeta 3 -->
            <div class="bg-white rounded-2xl border border-blue-100 shadow-sm shadow-blue-100/50 p-6 flex flex-col items-center text-center gap-4 hover:shadow-md hover:border-blue-200 transition-all">
                <div class="w-16 h-16 rounded-full bg-blue-50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-500 text-[36px]">lock</span>
                </div>
                <h3 class="text-label-md font-label-md text-blue-900 uppercase tracking-wide">Privacidad garantizada</h3>
                <p class="text-body-sm text-slate-600">Tu información y tu historial clínico se tratan con total confidencialidad y seguridad.</p>
            </div>

        </div>
    </div>
</section>
