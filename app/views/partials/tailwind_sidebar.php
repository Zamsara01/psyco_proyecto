<aside class="fixed inset-y-0 left-0 w-64 bg-white dark:bg-slate-900 border-r border-slate-100 dark:border-slate-800 shadow-sm flex flex-col z-40 transition-transform duration-300">
    
    <!-- Logo Header -->
    <div class="h-16 flex items-center px-6 border-b border-slate-100 dark:border-slate-800 shrink-0">
        <a href="<?= URL_BASE ?>" class="flex items-center gap-3">
            <img alt="PSYCO Logo" class="h-8 w-auto object-contain" src="<?= URL_BASE ?>public/img/psyco.png"/>
            <span class="text-xl font-bold text-orange-600 font-headline-sm hover:text-orange-700 transition-colors">
                PSYCO
            </span>
        </a>
    </div>

    <!-- Navegación Principal -->
    <nav class="flex-grow py-6 px-4 space-y-2 overflow-y-auto">
        <!-- Inicio -->
        <a href="<?= URL_BASE ?>" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:text-primary hover:bg-primary/5 transition-colors font-medium text-body-md group">
            <span class="material-symbols-outlined text-[22px] group-hover:text-primary text-slate-400">home</span>
            Inicio
        </a>

        <!-- Calendario -->
        <a href="<?= URL_BASE ?>calendario" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:text-primary hover:bg-primary/5 transition-colors font-medium text-body-md group">
            <span class="material-symbols-outlined text-[22px] group-hover:text-primary text-slate-400">calendar_month</span>
            Calendario
        </a>

        <!-- Chatbot -->
        <button onclick="openChatbotModal()" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:text-primary hover:bg-primary/5 transition-colors font-medium text-body-md group w-full text-left">
            <span class="material-symbols-outlined text-[22px] group-hover:text-primary text-slate-400">forum</span>
            Chatbot
        </button>

        <!-- Panel Psicólogas (Solo si hay sesión) -->
        <?php if(isset($_SESSION['user'])): ?>
        <a href="<?= URL_BASE ?>panel_psicologas" 
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg text-slate-600 hover:text-primary hover:bg-primary/5 transition-colors font-medium text-body-md group">
            <span class="material-symbols-outlined text-[22px] group-hover:text-primary text-slate-400">dashboard</span>
            Mi Panel
        </a>
        <?php endif; ?>
    </nav>

    <!-- Sección de Usuario (Bottom) -->
    <div class="border-t border-slate-100 dark:border-slate-800 p-4 shrink-0">
        <?php if(isset($_SESSION['user'])): ?>
            <!-- Usuario Logueado -->
            <div class="flex flex-col gap-3">
                <div class="flex items-center gap-3 px-2">
                    <div class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-primary font-bold">
                        <?= strtoupper(substr($_SESSION['user']['nombre'] ?? 'U', 0, 1)) ?>
                    </div>
                    <div class="flex flex-col overflow-hidden">
                        <span class="text-sm font-semibold text-slate-700 truncate">
                            <?= htmlspecialchars($_SESSION['user']['nombre'] ?? 'Usuario') ?>
                        </span>
                        <span class="text-xs text-slate-500 truncate">
                            <?= htmlspecialchars($_SESSION['user']['correo_electronico'] ?? '') ?>
                        </span>
                    </div>
                </div>
                
                <a href="<?= URL_BASE ?>users/logout" 
                   class="flex items-center justify-center gap-2 w-full px-4 py-2 mt-2 text-sm font-medium text-slate-600 bg-slate-50 hover:bg-red-50 hover:text-red-600 rounded-lg transition-colors border border-slate-200">
                    <span class="material-symbols-outlined text-[18px]">logout</span>
                    Cerrar sesión
                </a>
            </div>

        <?php else: ?>
            <!-- Invitado -->
            <div class="flex flex-col gap-2">
                <button onclick="openLoginModal()"
                        class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-white bg-primary hover:bg-primary/90 active:scale-[0.98] rounded-lg transition-all shadow-sm shadow-primary/20">
                    <span class="material-symbols-outlined text-[18px]">login</span>
                    Iniciar sesión
                </button>
                <button onclick="openRegisterModal()"
                        class="flex items-center justify-center gap-2 w-full px-4 py-2.5 text-sm font-bold text-primary bg-white border border-primary hover:bg-primary/5 active:scale-[0.98] rounded-lg transition-all">
                    <span class="material-symbols-outlined text-[18px]">person_add</span>
                    Registrarse
                </button>
            </div>
        <?php endif; ?>
    </div>
</aside>
