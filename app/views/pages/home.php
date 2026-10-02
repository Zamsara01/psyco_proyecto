<!-- ═══════════════════════════════════════════════════════════
     PSYCO — Página de Inicio (UI Reparada y Estable)
     ═══════════════════════════════════════════════════════════ -->

<style>
    /* Ocultar el sidebar general para tener la vista inmersiva a pantalla completa */
    #app-sidebar, header.lg\:hidden, .mobile-sidebar-toggle { display: none !important; }
    
    /* Configurar el main content para ocupar todo el espacio con el fondo */
    #main-content { 
        margin: 0 !important; 
        padding: 0 !important;
        width: 100vw !important;
        max-width: 100vw !important;
        min-height: 100vh !important;
        background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpeg') !important;
        background-size: cover !important;
        background-position: center !important;
        background-attachment: fixed !important;
        display: flex !important;
        flex-direction: column !important;
    }

    /* Forzar que el contenedor principal centre la tarjeta */
    main.flex-grow {
        display: flex !important;
        flex-direction: column !important;
        justify-content: center !important;
        align-items: center !important;
        width: 100% !important;
        min-height: 100vh !important;
        padding-top: 100px !important; /* Espacio para la barra superior */
        padding-bottom: 40px !important;
    }

    /* Tarjeta principal estilo sólido con borde y gran resplandor */
    .glass-card {
        background-color: #E9ECE3 !important; 
        box-shadow: 0 0 80px rgba(255, 255, 255, 0.9) !important;
        border: 2px solid rgba(255, 255, 255, 0.6) !important;
        border-radius: 2.5rem !important; /* Forzar siempre bordes redondos */
    }

    /* Colores de botones exactos a tu paleta */
    .btn-gestionar { background-color: #6B8CAE; color: white; }
    .btn-miscitas { background-color: #8DA399; color: white; }
    .btn-recursos { background-color: #A68A7B; color: white; }
    
    .btn-gestionar:hover { background-color: #5A7E9F; }
    .btn-miscitas:hover { background-color: #759286; }
    .btn-recursos:hover { background-color: #8C7164; }

    /* MODO OSCURO (Dark Mode) overrides */
    .dark #main-content {
        background-image: url('<?= URL_BASE ?>public/img/calendariobackgroundnoche.jpeg') !important;
    }
    .dark .glass-card {
        background-color: #1e293b !important; /* slate-800 */
        box-shadow: 0 25px 50px -12px rgba(0, 0, 0, 0.5) !important; /* shadow-2xl con más opacidad para modo oscuro */
        border: 1px solid #334155 !important; /* border-slate-700 */
    }
</style>

<!-- ── Barra Superior Blanca (Top Bar) ──────────────────────────── -->
<div class="fixed top-0 left-0 w-full bg-white/95 dark:bg-slate-900/95 backdrop-blur-sm shadow-sm flex items-center justify-between px-6 md:px-12 py-4 z-50 h-[72px]">
    <div class="flex items-center gap-3">
        <img src="<?= URL_BASE ?>public/img/psyco.png" alt="Logo" class="h-8 md:h-10" onerror="this.style.display='none'"> 
        <span class="font-extrabold text-slate-800 dark:text-white tracking-widest text-xl md:text-2xl" style="font-family: 'Plus Jakarta Sans', sans-serif;">PSYCO</span>
    </div>
    
    <div class="flex items-center gap-4 md:gap-6">
        <!-- Botón de Tema (Oscuro/Claro) -->
        <button onclick="toggleDarkMode()" class="text-slate-700 dark:text-slate-300 hover:text-black dark:hover:text-white transition-colors flex items-center" title="Cambiar tema">
            <span class="material-symbols-outlined text-[22px] dark:hidden">dark_mode</span>
            <span class="material-symbols-outlined text-[22px] hidden dark:block text-white">light_mode</span>
        </button>

        <?php if (!isset($_SESSION['user'])): ?>
        <button onclick="openLoginModal()" class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-black dark:hover:text-white font-bold transition-colors text-base md:text-lg">
            <span class="material-symbols-outlined text-[22px]">login</span>
            <span class="hidden md:inline">Iniciar sesión</span>
        </button>
        <button onclick="openRegisterModal()" class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-black dark:hover:text-white font-bold transition-colors text-base md:text-lg">
            <span class="material-symbols-outlined text-[22px]">person_add</span>
            <span class="hidden md:inline">Registrarse</span>
        </button>
        <?php else: ?>
            <?php if ($_SESSION['user']['rol'] === 'psicologo'): ?>
            <a href="<?= URL_BASE ?>panel_psicologas" class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-black dark:hover:text-white font-bold transition-colors text-base md:text-lg">
                <span class="material-symbols-outlined text-[22px]">dashboard</span>
                Mi Panel
            </a>
            <?php else: ?>
            <a href="<?= URL_BASE ?>citas/misCitas" class="flex items-center gap-2 text-slate-700 dark:text-slate-300 hover:text-black dark:hover:text-white font-bold transition-colors text-base md:text-lg">
                <span class="material-symbols-outlined text-[22px]">person</span>
                Mi Cuenta
            </a>
            <?php endif; ?>
        <?php endif; ?>
    </div>
</div>

<!-- ── Tarjeta Central ──────────────────────────────────────────── -->
<div class="relative glass-card w-[92%] max-w-3xl text-center px-8 pb-12 pt-0 mx-auto mt-12 md:mt-20">
    
    <!-- Logo en flujo normal con margen negativo (NUNCA chocará con el texto) -->
    <div class="flex justify-center -mt-24 md:-mt-32 mb-6">
        <img src="<?= URL_BASE ?>public/img/psyco.png" alt="PSYCO Logo Principal" class="h-[220px] md:h-[280px] object-contain drop-shadow-xl">
    </div>

    <!-- Contenido de Texto -->
    <div>
        <h1 class="text-3xl md:text-[2.6rem] mb-6 leading-tight font-black text-[#1c2e2a] dark:text-slate-100" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Un espacio seguro para<br>escucharte en PSYCO
        </h1>
        
        <p class="text-[17px] md:text-[19px] mb-10 leading-relaxed font-medium text-[#2a3c38] dark:text-slate-400 max-w-2xl mx-auto" style="font-family: 'Plus Jakarta Sans', sans-serif;">
            Nuestra plataforma escolar está diseñada para acompañarte cuando lo necesites. Conecta con tu psicóloga de forma segura y confidencial. Agenda tus citas y encuentra apoyo a tu ritmo, en un entorno de confianza.
        </p>

        <!-- Botones CTAs -->
        <div class="flex flex-wrap justify-center gap-4 md:gap-5">
            
            <button onclick="openAcceso RápidoModal()" class="btn-gestionar flex items-center gap-2 px-6 py-3.5 rounded-2xl font-bold text-base shadow-lg transition-transform hover:scale-105 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">smart_toy</span>
                Gestionar Citas
            </button>
            
            <?php if (isset($_SESSION['user']) && $_SESSION['user']['rol'] === 'psicologo'): ?>
                <a href="<?= URL_BASE ?>calendario" class="btn-miscitas flex items-center gap-2 px-6 py-3.5 rounded-2xl font-bold text-base shadow-lg transition-transform hover:scale-105 active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">calendar_month</span>
                    Calendario
                </a>
            <?php else: ?>
                <a href="<?= URL_BASE ?>citas/misCitas" class="btn-miscitas flex items-center gap-2 px-6 py-3.5 rounded-2xl font-bold text-base shadow-lg transition-transform hover:scale-105 active:scale-95">
                    <span class="material-symbols-outlined text-[20px]">event_note</span>
                    Mis Citas
                </a>
            <?php endif; ?>
            
            <a href="<?= URL_BASE ?>citas/misRecursos" class="btn-recursos flex items-center gap-2 px-6 py-3.5 rounded-2xl font-bold text-base shadow-lg transition-transform hover:scale-105 active:scale-95">
                <span class="material-symbols-outlined text-[20px]">auto_stories</span>
                Mis Recursos
            </a>

        </div>
    </div>
</div>
