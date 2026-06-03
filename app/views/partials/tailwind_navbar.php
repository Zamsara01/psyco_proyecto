<header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 shadow-sm flex justify-between items-center w-full px-6 h-16 sticky top-0 z-40">
    <div class="flex items-center gap-3">
        <img alt="PSYCO Logo" class="h-8 w-auto object-contain" src="<?= URL_BASE ?>public/img/logo.png"/>
        <a href="<?= URL_BASE ?>" class="text-xl font-bold text-orange-600 font-headline-sm hover:text-orange-700 transition-colors">
            PSYCO
        </a>
    </div>
    <div class="flex items-center gap-4">
        <!-- Dashboard Link (condicional) -->
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="<?= URL_BASE ?>panel_psicologas" class="text-slate-500 hover:text-orange-600 transition-colors font-body-sm font-medium mr-4">Mi Panel</a>
        <?php endif; ?>

        <button class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors active:scale-95 duration-200">
            <span class="material-symbols-outlined">help_outline</span>
        </button>
        <?php if(isset($_SESSION['user_id'])): ?>
            <a href="<?= URL_BASE ?>users/logout" class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors active:scale-95 duration-200" title="Cerrar sesión">
                <span class="material-symbols-outlined">logout</span>
            </a>
        <?php else: ?>
            <a href="<?= URL_BASE ?>users/login" class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors active:scale-95 duration-200" title="Iniciar sesión">
                <span class="material-symbols-outlined">account_circle</span>
            </a>
        <?php endif; ?>
    </div>
</header>
