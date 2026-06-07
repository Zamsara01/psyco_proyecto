<!-- ═══════════════════════════════════════════════════════════
     PSYCO — Página de Inicio
     ═══════════════════════════════════════════════════════════ -->

<!-- ── Hero ──────────────────────────────────────────────────── -->
<section class="relative flex-grow flex items-center justify-center py-24 px-6 overflow-hidden">

    <!-- Blobs decorativos de fondo -->
    <div class="absolute inset-0 pointer-events-none -z-10">
        <div class="absolute top-[-15%] right-[-10%] w-[550px] h-[550px] rounded-full bg-primary/5 blur-3xl"></div>
        <div class="absolute bottom-[-15%] left-[-10%] w-[450px] h-[450px] rounded-full bg-orange-500/5 blur-3xl"></div>
    </div>

    <div class="max-w-3xl mx-auto text-center">

        <!-- Logo -->
        <div class="flex justify-center mb-6">
            <img src="<?= URL_BASE ?>public/img/psyco.png" alt="PSYCO Logo" class="h-[560px]">
        </div>

        <!-- Título principal -->
        <h1 class="text-headline-md font-headline-md text-on-surface mb-4 leading-tight">
            Bienvenido a <span class="text-primary">PSYCO</span>
        </h1>

        <!-- Subtítulo -->
        <p class="text-body-md font-body-md text-on-surface-variant max-w-xl mx-auto mb-10 leading-relaxed">
            Una plataforma de apoyo psicológico escolar diseñada para conectar a estudiantes con su psicóloga de manera segura, organizada y discreta. Agenda citas, consulta tu historial y accede a orientación cuando más lo necesites.
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
                   class="inline-flex items-center justify-center gap-2 h-12 px-8 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">person_add</span>
                    Crear cuenta
                </button>
                <button onclick="openLoginModal()"
                   class="inline-flex items-center justify-center gap-2 h-12 px-8 border-2 border-primary text-primary font-bold rounded-xl hover:bg-primary/5 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">login</span>
                    Iniciar sesión
                </button>
            <?php endif; ?>
        </div>
    </div>
</section>

<!-- ── Características ───────────────────────────────────────── -->
<section class="py-16 px-6 bg-surface-container-low">
    <div class="max-w-5xl mx-auto">

        <h2 class="text-headline-sm font-headline-md text-on-surface text-center mb-10">¿Qué puedes hacer en PSYCO?</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <!-- Tarjeta 1 -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col items-center text-center gap-4 hover:shadow-md transition-shadow">
                <span class="material-symbols-outlined text-primary text-[42px]">calendar_month</span>
                <h3 class="text-label-md font-label-md text-on-surface uppercase tracking-wide">Agenda tu cita</h3>
                <p class="text-body-sm text-on-surface-variant">Solicita una sesión con la psicóloga disponible en los horarios que mejor se adapten a ti.</p>
            </div>

            <!-- Tarjeta 2 -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col items-center text-center gap-4 hover:shadow-md transition-shadow">
                <span class="material-symbols-outlined text-primary text-[42px]">chat_bubble</span>
                <h3 class="text-label-md font-label-md text-on-surface uppercase tracking-wide">Chatbot de orientación</h3>
                <p class="text-body-sm text-on-surface-variant">Nuestro asistente virtual te guía en el proceso y responde tus dudas de forma inmediata.</p>
            </div>

            <!-- Tarjeta 3 -->
            <div class="bg-white rounded-2xl border border-slate-100 shadow-sm p-6 flex flex-col items-center text-center gap-4 hover:shadow-md transition-shadow">
                <span class="material-symbols-outlined text-primary text-[42px]">lock</span>
                <h3 class="text-label-md font-label-md text-on-surface uppercase tracking-wide">Privacidad garantizada</h3>
                <p class="text-body-sm text-on-surface-variant">Tu información y tu historial clínico se tratan con total confidencialidad y seguridad.</p>
            </div>

        </div>
    </div>
</section>
