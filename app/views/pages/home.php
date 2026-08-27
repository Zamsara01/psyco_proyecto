<!-- ═══════════════════════════════════════════════════════════
     PSYCO — Página de Inicio
     ═══════════════════════════════════════════════════════════ -->

<!-- ── Hero ──────────────────────────────────────────────────── -->
<section class="relative flex-grow flex items-center justify-center py-16 sm:py-24 px-6 overflow-hidden bg-gradient-to-br from-[#2563eb] via-[#1e88d0] to-[#16a34a] dark:from-blue-950 dark:via-slate-900 dark:to-emerald-950">

    <!-- Blobs decorativos adicionales para dar dinamismo -->
    <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
        <div class="absolute top-[-20%] left-[-10%] w-[550px] h-[550px] rounded-full bg-white/15 blur-3xl"></div>
        <div class="absolute bottom-[-20%] right-[-10%] w-[450px] h-[450px] rounded-full bg-green-400/20 blur-3xl"></div>
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
                   class="inline-flex items-center justify-center gap-2 h-12 px-8 bg-gradient-to-r from-emerald-500 to-green-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/20 hover:from-emerald-600 hover:to-green-700 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">smart_toy</span>
                    Gestionar Citas
                </button>
                <a href="<?= URL_BASE ?>citas/misCitas"
                   class="inline-flex items-center justify-center gap-2 h-12 px-6 border-2 border-white/60 text-white font-bold rounded-xl hover:bg-white/10 hover:border-white transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">event_note</span>
                    Mis Citas
                </a>
                <a href="<?= URL_BASE ?>citas/misRecursos"
                   class="inline-flex items-center justify-center gap-2 h-12 px-6 border-2 border-white/60 text-white font-bold rounded-xl hover:bg-white/10 hover:border-white transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">auto_stories</span>
                    Mis Recursos
                </a>
            <?php elseif ($rol === 'psicologo'): ?>
                <!-- Opciones para Psicóloga -->
                <a href="<?= URL_BASE ?>panel_psicologas"
                   class="inline-flex items-center justify-center gap-2 h-12 px-8 bg-gradient-to-r from-emerald-500 to-green-600 text-white font-bold rounded-xl shadow-lg shadow-emerald-600/20 hover:from-emerald-600 hover:to-green-700 transition-all active:scale-[0.98] text-body-md">
                    <span class="material-symbols-outlined text-[20px]">dashboard</span>
                    Ir a Mi Panel
                </a>
                <a href="<?= URL_BASE ?>calendario"
                   class="inline-flex items-center justify-center gap-2 h-12 px-6 border-2 border-white/60 text-white font-bold rounded-xl hover:bg-white/10 hover:border-white transition-all active:scale-[0.98] text-body-md">
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
<section class="py-16 px-6 bg-transparent">
    <div class="max-w-5xl mx-auto">

        <h2 class="text-headline-sm font-headline-md text-blue-900 dark:text-blue-100 text-center mb-10">¿Qué ofrece PSYCO?</h2>

        <div class="grid grid-cols-1 sm:grid-cols-3 gap-6">

            <!-- Tarjeta 1 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-blue-100 dark:border-slate-700 shadow-sm shadow-blue-100/50 dark:shadow-none p-6 flex flex-col items-center text-center gap-4 hover:shadow-md hover:border-blue-200 dark:hover:border-blue-500 transition-all">
                <div class="w-16 h-16 rounded-full bg-blue-50 dark:bg-slate-700/50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-500 dark:text-blue-400 text-[36px]">calendar_month</span>
                </div>
                <h3 class="text-label-md font-label-md text-blue-900 dark:text-blue-100 uppercase tracking-wide">Agenda tu cita</h3>
                <p class="text-body-sm text-slate-600 dark:text-slate-400">Solicita una sesión con la psicóloga disponible en los horarios que mejor se adapten a ti.</p>
            </div>

            <!-- Tarjeta 2 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-emerald-100 dark:border-slate-700 shadow-sm shadow-emerald-100/50 dark:shadow-none p-6 flex flex-col items-center text-center gap-4 hover:shadow-md hover:border-emerald-200 dark:hover:border-emerald-500 transition-all">
                <div class="w-16 h-16 rounded-full bg-emerald-50 dark:bg-slate-700/50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-emerald-500 dark:text-emerald-400 text-[36px]">chat_bubble</span>
                </div>
                <h3 class="text-label-md font-label-md text-emerald-900 dark:text-emerald-100 uppercase tracking-wide">Chatbot de orientación</h3>
                <p class="text-body-sm text-slate-600 dark:text-slate-400">Nuestro asistente virtual te guía en el proceso y responde tus dudas de forma inmediata.</p>
            </div>

            <!-- Tarjeta 3 -->
            <div class="bg-white dark:bg-slate-800 rounded-2xl border border-blue-100 dark:border-slate-700 shadow-sm shadow-blue-100/50 dark:shadow-none p-6 flex flex-col items-center text-center gap-4 hover:shadow-md hover:border-blue-200 dark:hover:border-blue-500 transition-all">
                <div class="w-16 h-16 rounded-full bg-blue-50 dark:bg-slate-700/50 flex items-center justify-center">
                    <span class="material-symbols-outlined text-blue-500 dark:text-blue-400 text-[36px]">lock</span>
                </div>
                <h3 class="text-label-md font-label-md text-blue-900 dark:text-blue-100 uppercase tracking-wide">Privacidad garantizada</h3>
                <p class="text-body-sm text-slate-600 dark:text-slate-400">Tu información y tu historial clínico se tratan con total confidencialidad y seguridad.</p>
            </div>

        </div>
    </div>
</section>

<!-- ── Presentación ───────────────────────────────────────── -->
<?php if ($rol === null): ?>
<section id="presentacion" class="py-16 px-6 bg-slate-50 dark:bg-slate-900 flex justify-center w-full">
    <div class="flex flex-row gap-6 w-full max-w-6xl items-stretch justify-center">
        <!-- Tarjeta Principal (Información) -->
        <div class="w-[70%] p-12 space-y-8 bg-gradient-to-r from-cyan-300 to-blue-500 text-center flex flex-col items-center justify-center rounded-3xl shadow-xl border-4 border-solid border-cyan-200 shrink-0">
            <h2 class="text-7xl font-normal text-black mb-6 tracking-wide" style="font-family: Georgia, serif;">Psyco</h2>
            
            <div class="space-y-8 w-full max-w-lg mx-auto text-black">
                <div>
                    <h3 class="flex items-center justify-center gap-2 text-xl font-bold mb-2">
                        <span>🧠</span> Integrantes
                    </h3>
                    <p class="font-bold text-lg leading-relaxed">Matías Arboleda · Simón Atehortúa · David Bedoya · Ayleen Martínez</p>
                </div>

                <div>
                    <h3 class="flex items-center justify-center gap-2 text-xl font-bold mb-2">
                        <span>🏫</span> Institución
                    </h3>
                    <p class="font-bold text-lg leading-relaxed">I.E. Barrio Santa Margarita Medellín<br>17 de abril de 2026</p>
                </div>

                <div>
                    <h3 class="flex items-center justify-center gap-2 text-xl font-bold mb-2">
                        <span>🧑‍🏫</span> Profesores
                    </h3>
                    <p class="font-bold text-lg leading-relaxed">Jairo Cano - Arnaldo Dominguez - Iván Castro - William Montoya</p>
                </div>
            </div>
        </div>

        <!-- Tarjeta Secundaria (Logos pequeños) -->
        <div class="w-[30%] bg-white p-8 flex flex-col items-center justify-center text-center space-y-8 rounded-3xl shadow-xl border-4 border-solid border-slate-200 shrink-0">
            
            <img src="<?= URL_BASE ?>public/img/psyco.png" alt="Psyco" class="w-32 object-contain drop-shadow-md">
            
            <p class="text-base font-normal text-black underline decoration-black decoration-1 underline-offset-4 px-2" style="font-family: Georgia, serif;">
                Un sistema ordenado para un bienestar adecuado
            </p>
            
            <div class="flex flex-col items-center justify-center gap-6 w-full mt-4">
                <img src="<?= URL_BASE ?>public/img/sena.png" alt="Sena" class="h-16 w-auto object-contain">
                <img src="<?= URL_BASE ?>public/img/logo.png" alt="Logo IE" class="h-16 w-auto object-contain">
            </div>
            
        </div>
    </div>
</section>
<?php endif; ?>
