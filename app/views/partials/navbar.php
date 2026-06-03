<?php
$userProfile = $_SESSION['user']['perfil'] ?? '';
$userName    = $_SESSION['user']['nombre'] ?? '';
?>

<header class="bg-white dark:bg-slate-900 border-b border-slate-100 dark:border-slate-800 shadow-sm flex justify-between items-center w-full px-6 h-16 sticky top-0 z-40">
    
    <!-- Logo -->
    <div class="flex items-center gap-3">
        <img alt="PSYCO Logo" class="h-8 w-auto object-contain" src="<?= URL_BASE ?>public/img/psycoLogo.png"/>
        <a href="<?= URL_BASE ?>" class="text-xl font-bold text-orange-600 font-headline-sm hover:text-orange-700 transition-colors">
            PSYCO
        </a>
    </div>

    <!-- Derecha -->
    <div class="flex items-center gap-4">

        <!-- Botón ayuda -->
        <button class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
            <span class="material-symbols-outlined">help_outline</span>
        </button>

        <?php if (!isset($_SESSION['user'])): ?>
            <!-- Sin sesión: dropdown Ingresar / Registrarse -->
            <div class="relative" id="dropdown-guest">
                <button onclick="toggleDropdown('menu-guest')"
                        class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined">account_circle</span>
                </button>
                <div id="menu-guest"
                     class="hidden absolute right-0 mt-2 w-44 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-lg shadow-lg z-50">
                    <a href="<?= URL_BASE ?>users/login"
                       class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-t-lg">
                        Ingresar
                    </a>
                    <a href="<?= URL_BASE ?>users/register"
                       class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-b-lg">
                        Registrarse
                    </a>
                </div>
            </div>

        <?php elseif ($userProfile === 'administrador'): ?>
            <!-- Admin: saludo + dropdown con opciones de admin -->
            <span class="text-sm text-slate-500 font-medium hidden sm:block">
                Hola, <?= htmlspecialchars($userName) ?>
            </span>
            <div class="relative">
                <button onclick="toggleDropdown('menu-admin')"
                        class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined">manage_accounts</span>
                </button>
                <div id="menu-admin"
                     class="hidden absolute right-0 mt-2 w-48 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-lg shadow-lg z-50">
                    <a href="<?= URL_BASE ?>users/list"
                       class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-t-lg">
                        Ver Usuarios
                    </a>
                    <a href="<?= URL_BASE ?>users/register"
                       class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700">
                        Registrar Usuario
                    </a>
                    <a href="<?= URL_BASE ?>products/list"
                       class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700">
                        Ver Productos
                    </a>
                    <hr class="border-slate-100 dark:border-slate-700">
                    <a href="<?= URL_BASE ?>users/logout"
                       class="block px-4 py-2 text-sm text-red-500 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-b-lg">
                        Cerrar sesión
                    </a>
                </div>
            </div>

        <?php elseif ($userProfile === 'usuario'): ?>
            <!-- Usuario regular: saludo + dropdown básico -->
            <span class="text-sm text-slate-500 font-medium hidden sm:block">
                Hola, <?= htmlspecialchars($userName) ?>
            </span>
            <div class="relative">
                <button onclick="toggleDropdown('menu-user')"
                        class="p-2 rounded-full text-slate-500 hover:bg-slate-50 dark:hover:bg-slate-800 transition-colors">
                    <span class="material-symbols-outlined">account_circle</span>
                </button>
                <div id="menu-user"
                     class="hidden absolute right-0 mt-2 w-44 bg-white dark:bg-slate-800 border border-slate-100 dark:border-slate-700 rounded-lg shadow-lg z-50">
                    <a href="<?= URL_BASE ?>panel_psicologas"
                       class="block px-4 py-2 text-sm text-slate-700 dark:text-slate-200 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-t-lg">
                        Mi Panel
                    </a>
                    <hr class="border-slate-100 dark:border-slate-700">
                    <a href="<?= URL_BASE ?>users/logout"
                       class="block px-4 py-2 text-sm text-red-500 hover:bg-slate-50 dark:hover:bg-slate-700 rounded-b-lg">
                        Cerrar sesión
                    </a>
                </div>
            </div>

        <?php endif; ?>
    </div>
</header>

<!-- Script para abrir/cerrar dropdowns -->
<script>
function toggleDropdown(id) {
    const menu = document.getElementById(id);
    menu.classList.toggle('hidden');
}

// Cerrar dropdown al hacer click fuera
document.addEventListener('click', function(e) {
    if (!e.target.closest('[id^="dropdown-"], .relative')) {
        document.querySelectorAll('[id^="menu-"]').forEach(m => m.classList.add('hidden'));
    }
});
</script>