<!-- ═══════════════════════════════════════════════════════════
     PSYCO — Página de Inicio
     ═══════════════════════════════════════════════════════════ -->

<!-- Fondo global fijo para evitar cortes -->
<div class="fixed inset-0 pointer-events-none -z-50 bg-gradient-to-br from-[#2563eb] via-[#1e88d0] to-[#16a34a] dark:from-blue-950 dark:via-slate-900 dark:to-emerald-950"></div>

<?php
$stroke      = "-webkit-text-stroke: 1px black; text-shadow: 2px 2px 6px rgba(0,0,0,0.85);";
$fontPoppins = "font-family: 'Poppins', sans-serif; font-weight: 600; color: #ffffff; $stroke";
$fontRubik   = "font-family: 'Rubik', sans-serif; font-weight: 700; color: #1d4ed8; -webkit-text-stroke: 0.5px rgba(0,0,0,0.4); text-shadow: 1px 1px 3px rgba(0,0,0,0.3);";
?>

<!-- Wrapper global transparente -->
<div class="flex-grow flex flex-col min-h-full">

    <!-- ── Hero ──────────────────────────────────────────────────── -->
    <section class="relative flex-grow flex items-center justify-center py-16 sm:py-24 px-6 overflow-hidden">

        <!-- Blobs decorativos -->
        <div class="absolute inset-0 pointer-events-none z-0 overflow-hidden">
            <div class="absolute top-[-20%] left-[-10%] w-[550px] h-[550px] rounded-full bg-white/15 blur-3xl"></div>
            <div class="absolute bottom-[-20%] right-[-10%] w-[450px] h-[450px] rounded-full bg-green-400/20 blur-3xl"></div>
        </div>

        <div class="w-full max-w-5xl mx-auto text-center relative z-10">

            <!-- Logo -->
            <div class="flex justify-center mb-10">
                <img src="<?= URL_BASE ?>public/img/psyco.png" alt="PSYCO Logo"
                     class="h-[300px] sm:h-[450px] md:h-[600px] lg:h-[700px] object-contain drop-shadow-2xl">
            </div>

            <!-- Título principal -->
            <h1 class="text-4xl sm:text-5xl md:text-6xl lg:text-7xl font-bold mb-6 leading-tight"
                style="<?= $fontPoppins ?>">
                Un espacio seguro para escucharte en
                <span style="color: #6ee7b7; -webkit-text-stroke: 1px black; text-shadow: 2px 2px 6px rgba(0,0,0,0.85);">PSYCO</span>
            </h1>

            <!-- Subtítulo -->
            <p class="text-2xl sm:text-3xl md:text-4xl lg:text-5xl max-w-5xl mx-auto mb-24 leading-relaxed"
               style="<?= $fontPoppins ?>">
                Nuestra plataforma escolar está diseñada para acompañarte cuando lo necesites. Conecta con tu psicóloga de forma segura y confidencial. Agenda tus citas y encuentra apoyo a tu ritmo, en un entorno de confianza.
            </p>

            <!-- CTAs -->
            <div class="flex flex-col sm:flex-row gap-6 justify-center">
                <?php
                $rol = $_SESSION['user']['rol'] ?? null;
                if ($rol === 'paciente'): ?>
                    <button onclick="openChatbotModal()"
                        class="inline-flex items-center justify-center gap-3 h-16 px-16 bg-white font-bold text-xl rounded-xl shadow-lg hover:bg-slate-100 transition-all active:scale-[0.98]"
                        style="<?= $fontRubik ?>">
                        <span class="material-symbols-outlined text-[28px]">smart_toy</span>
                        Gestionar Citas
                    </button>
                    <a href="<?= URL_BASE ?>citas/misCitas"
                        class="inline-flex items-center justify-center gap-3 h-16 px-16 bg-white font-bold text-xl rounded-xl shadow-lg hover:bg-slate-100 transition-all active:scale-[0.98]"
                        style="<?= $fontRubik ?>">
                        <span class="material-symbols-outlined text-[28px]">event_note</span>
                        Mis Citas
                    </a>
                    <a href="<?= URL_BASE ?>citas/misRecursos"
                        class="inline-flex items-center justify-center gap-3 h-16 px-16 bg-white font-bold text-xl rounded-xl shadow-lg hover:bg-slate-100 transition-all active:scale-[0.98]"
                        style="<?= $fontRubik ?>">
                        <span class="material-symbols-outlined text-[28px]">auto_stories</span>
                        Mis Recursos
                    </a>
                <?php elseif ($rol === 'psicologo'): ?>
                    <a href="<?= URL_BASE ?>panel_psicologas"
                        class="inline-flex items-center justify-center gap-3 h-16 px-16 bg-white font-bold text-xl rounded-xl shadow-lg hover:bg-slate-100 transition-all active:scale-[0.98]"
                        style="<?= $fontRubik ?>">
                        <span class="material-symbols-outlined text-[28px]">dashboard</span>
                        Ir a Mi Panel
                    </a>
                    <a href="<?= URL_BASE ?>calendario"
                        class="inline-flex items-center justify-center gap-3 h-16 px-16 bg-white font-bold text-xl rounded-xl shadow-lg hover:bg-slate-100 transition-all active:scale-[0.98]"
                        style="<?= $fontRubik ?>">
                        <span class="material-symbols-outlined text-[28px]">calendar_month</span>
                        Calendario
                    </a>
                <?php else: ?>
                    <button onclick="openRegisterModal()"
                        class="inline-flex items-center justify-center gap-3 h-16 px-16 bg-white font-bold text-xl rounded-xl shadow-lg hover:bg-slate-100 transition-all active:scale-[0.98]"
                        style="<?= $fontRubik ?>">
                        <span class="material-symbols-outlined text-[28px]">person_add</span>
                        Crear cuenta
                    </button>
                    <button onclick="openLoginModal()"
                        class="inline-flex items-center justify-center gap-3 h-16 px-16 bg-white font-bold text-xl rounded-xl shadow-lg hover:bg-slate-100 transition-all active:scale-[0.98]"
                        style="<?= $fontRubik ?>">
                        <span class="material-symbols-outlined text-[28px]">login</span>
                        Iniciar sesión
                    </button>
                <?php endif; ?>
            </div>

        </div>
    </section>

</div>
