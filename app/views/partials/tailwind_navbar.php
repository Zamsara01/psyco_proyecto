<header class="bg-white dark:bg-[#2a2926] border-b border-slate-100 dark:border-white/5 shadow-sm flex justify-between items-center w-full px-4 sm:px-6 h-16 sticky top-0 z-20">
    <div class="flex items-center gap-3">
        <!-- Botón hamburguesa (solo móvil / tablet) -->
        <button onclick="openSidebar()" aria-label="Abrir menú"
            class="lg:hidden p-2 rounded-xl text-slate-500 dark:text-[#a39c8e] hover:bg-slate-100 dark:hover:bg-white/5 hover:text-blue-600 dark:hover:text-[#D7E6D5] transition-colors active:scale-95">
            <span class="material-symbols-outlined text-[24px]">menu</span>
        </button>
        <img alt="PSYCO Logo" class="h-8 w-auto object-contain hidden sm:block" src="<?= URL_BASE ?>public/img/psyco.png"/>
        <a href="<?= URL_BASE ?>" class="text-xl font-bold bg-gradient-to-r from-blue-600 to-green-600 bg-clip-text text-transparent hover:opacity-90 transition-opacity">
            PSYCO
        </a>
    </div>
    <div class="flex items-center gap-4">

        <!-- Botón Tema Oscuro -->
        <button onclick="toggleDarkMode()" class="p-2 rounded-full text-slate-500 dark:text-[#a39c8e] hover:bg-slate-100 dark:hover:bg-white/5 dark:hover:text-[#E4EAE6] transition-colors" title="Cambiar tema">
            <span class="material-symbols-outlined dark:hidden">dark_mode</span>
            <span class="material-symbols-outlined hidden dark:block">light_mode</span>
        </button>

        <?php if (isset($_SESSION['user'])): ?>
            <!-- Sesión activa: saludo + logout -->
            <span class="text-sm text-slate-500 dark:text-[#8DA399] font-medium hidden sm:block">
                Hola, <?= htmlspecialchars($_SESSION['user']['nombre'] ?? 'Usuario') ?>
            </span>
            <a href="<?= URL_BASE ?>users/logout"
               class="p-2 rounded-full text-slate-500 dark:text-[#a39c8e] hover:bg-slate-50 dark:hover:bg-white/5 dark:hover:text-[#E4EAE6] transition-colors active:scale-95 duration-200"
               title="Cerrar sesión">
                <span class="material-symbols-outlined">logout</span>
            </a>

        <?php else: ?>
            <!-- Sin sesión: botones directos de Iniciar sesión / Registrarse -->
            <button onclick="openLoginModal()" class="flex items-center gap-2 text-slate-600 dark:text-[#a39c8e] hover:text-black dark:hover:text-[#E4EAE6] font-semibold transition-colors text-sm sm:text-base">
                <span class="material-symbols-outlined text-[20px]">login</span>
                <span class="hidden sm:inline">Iniciar sesión</span>
            </button>
            <button onclick="openRegisterModal()" class="flex items-center gap-2 text-slate-600 dark:text-[#a39c8e] hover:text-black dark:hover:text-[#E4EAE6] font-semibold transition-colors text-sm sm:text-base">
                <span class="material-symbols-outlined text-[20px]">person_add</span>
                <span class="hidden sm:inline">Registrarse</span>
            </button>
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
