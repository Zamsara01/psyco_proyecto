<header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 shadow-sm flex justify-between items-center w-full px-4 sm:px-6 h-16 sticky top-0 z-20">
    <div class="flex items-center gap-3">
        <!-- Botón hamburguesa (solo móvil / tablet) -->
        <button onclick="openSidebar()" aria-label="Abrir menú"
            class="lg:hidden p-2 rounded-xl text-slate-500 hover:bg-slate-100 hover:text-orange-600 transition-colors active:scale-95">
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>
        <img alt="PSYCO Logo" class="h-8 w-auto object-contain hidden sm:block" src="<?= URL_BASE ?>public/img/psyco.png"/>
        <a href="<?= URL_BASE ?>" class="text-xl font-bold text-orange-600 font-headline-sm hover:text-orange-700 transition-colors">
            PSYCO
        </a>
    </div>
    <div class="flex items-center gap-4">

        <?php if (isset($_SESSION['user'])): ?>
            <!-- Sesión activa: saludo + logout -->
            <span class="text-sm text-slate-500 font-medium hidden sm:block">
                Hola, <?= htmlspecialchars($_SESSION['user']['nombre'] ?? 'Usuario') ?>
            </span>
            <a href="<?= URL_BASE ?>users/logout"
               class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors active:scale-95 duration-200"
               title="Cerrar sesión">
                <span class="material-symbols-outlined">logout</span>
            </a>

        <?php else: ?>
            <!-- Sin sesión: dropdown con Iniciar sesión / Registrarse -->
            <div class="relative" id="nav-guest-dropdown">
                <button onclick="toggleNavDropdown()"
                        class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors active:scale-95 duration-200"
                        title="Cuenta" aria-haspopup="true" aria-expanded="false" id="nav-guest-btn">
                    <span class="material-symbols-outlined">account_circle</span>
                </button>

                <!-- Menú desplegable -->
                <div id="nav-guest-menu"
                     class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700
                            rounded-xl shadow-lg z-50 overflow-hidden
                            origin-top-right transition-all duration-150">

                    <button onclick="closeNavDropdown(); openLoginModal();"
                            class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200
                                   hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-left">
                        <span class="material-symbols-outlined text-[18px] text-primary">login</span>
                        Iniciar sesión
                    </button>

                    <div class="h-px bg-slate-100 dark:bg-slate-700 mx-3"></div>

                    <button onclick="closeNavDropdown(); openRegisterModal();"
                       class="w-full flex items-center gap-3 px-4 py-3 text-sm text-slate-700 dark:text-slate-200
                              hover:bg-slate-50 dark:hover:bg-slate-700 transition-colors text-left">
                        <span class="material-symbols-outlined text-[18px] text-orange-500">person_add</span>
                        Registrarse
                    </button>
                </div>
            </div>
        <?php endif; ?>

    </div>
</header>

<script>
    function toggleNavDropdown() {
        const menu = document.getElementById('nav-guest-menu');
        const btn  = document.getElementById('nav-guest-btn');
        const open = !menu.classList.contains('hidden');
        menu.classList.toggle('hidden', open);
        btn.setAttribute('aria-expanded', String(!open));
    }
    function closeNavDropdown() {
        const menu = document.getElementById('nav-guest-menu');
        const btn  = document.getElementById('nav-guest-btn');
        if (menu) menu.classList.add('hidden');
        if (btn)  btn.setAttribute('aria-expanded', 'false');
    }
    // Cerrar al hacer click fuera
    document.addEventListener('click', function(e) {
        const wrapper = document.getElementById('nav-guest-dropdown');
        if (wrapper && !wrapper.contains(e.target)) closeNavDropdown();
    });
</script>
