<!-- ═══════════════════════════════════════════════════════════
     MODAL DE LOGIN — se incluye en el layout global
     Se abre con: document.getElementById('loginModal').classList.remove('hidden')
     ═══════════════════════════════════════════════════════════ -->

<!-- Overlay -->
<div id="loginModal"
     class="fixed inset-0 z-50 hidden flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="loginModalTitle">

    <!-- Backdrop -->
    <div id="loginModalBackdrop"
         class="absolute inset-0 bg-black/50 backdrop-blur-sm"
         onclick="closeLoginModal()"></div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden
                animate-[fadeInScale_0.2s_ease-out]">

        <!-- Botón cerrar -->
        <button onclick="closeLoginModal()"
                class="absolute top-4 right-4 p-1.5 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors focus:outline-none"
                aria-label="Cerrar">
            <span class="material-symbols-outlined text-[22px]">close</span>
        </button>

        <!-- Logo + encabezado -->
        <div class="pt-8 px-8 flex flex-col items-center">
            <div class="w-20 h-20 mb-4 flex items-center justify-center overflow-hidden">
                <img alt="PSYCO Logo" class="w-full h-full object-contain" src="<?= URL_BASE ?>public/img/psyco.png"/>
            </div>
            <h2 id="loginModalTitle" class="font-headline-md text-headline-md text-on-surface text-center">Bienvenido de nuevo</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant text-center mt-1">Inicia sesión para gestionar tus citas y recursos.</p>
        </div>

        <!-- Mensaje de error -->
        <?php if (!empty($loginError)): ?>
            <div class="mx-8 mt-4 bg-red-50 text-red-700 p-3 rounded-lg flex items-center gap-2 text-sm">
                <span class="material-symbols-outlined text-[18px]">error</span>
                <span><?= htmlspecialchars($loginError) ?></span>
            </div>
        <?php endif; ?>

        <!-- Formulario -->
        <form class="px-8 pt-6 pb-2 space-y-4" method="POST" action="<?= URL_BASE ?>users/authenticate">

            <!-- Email -->
            <div class="space-y-1.5">
                <label class="text-label-md font-label-md text-on-surface-variant block" for="loginEmail">Correo electrónico</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-on-surface-variant text-[20px]">mail</span>
                    <input id="loginEmail" name="txtEmail" type="email" placeholder="ejemplo@correo.com" required
                           class="w-full pl-10 pr-4 h-11 bg-surface-container-low border border-slate-200 rounded-lg
                                  focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none"/>
                </div>
            </div>

            <!-- Contraseña -->
            <div class="space-y-1.5">
                <label class="text-label-md font-label-md text-on-surface-variant block" for="loginPassword">Contraseña</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-on-surface-variant text-[20px]">lock</span>
                    <input id="loginPassword" name="txtPassword" type="password" placeholder="••••••••" required
                           class="w-full pl-10 pr-12 h-11 bg-surface-container-low border border-slate-200 rounded-lg
                                  focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none"/>
                    <button type="button"
                            onclick="const p=document.getElementById('loginPassword'); p.type=p.type==='password'?'text':'password'; this.innerText=p.type==='password'?'visibility_off':'visibility';"
                            class="material-symbols-outlined absolute right-3 text-on-surface-variant hover:text-on-surface transition-colors focus:outline-none text-[20px]">
                        visibility_off
                    </button>
                </div>
            </div>

            <!-- Botón submit -->
            <div class="pt-2">
                <button type="submit"
                        class="w-full h-12 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20
                               hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2 text-body-md">
                    Iniciar sesión
                    <span class="material-symbols-outlined text-[20px]">login</span>
                </button>
            </div>
        </form>

        <!-- Footer del modal -->
        <div class="px-8 pb-7 pt-4 flex flex-col gap-3">
            <div class="flex items-center gap-3">
                <div class="h-px flex-grow bg-slate-200"></div>
                <span class="text-label-md text-on-surface-variant">o</span>
                <div class="h-px flex-grow bg-slate-200"></div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between gap-2 text-sm">
                <a href="#" class="text-primary hover:underline font-body-sm">Olvidé mi contraseña</a>
                <button type="button" onclick="closeLoginModal(); openRegisterModal();" class="text-orange-600 font-semibold hover:text-orange-700 font-body-sm bg-transparent border-none cursor-pointer">
                    ¿No tienes cuenta? Regístrate
                </button>
            </div>
        </div>
    </div>
</div>

<style>
    @keyframes fadeInScale {
        from { opacity: 0; transform: scale(0.95) translateY(8px); }
        to   { opacity: 1; transform: scale(1)    translateY(0);   }
    }
</style>

<script>
    function openLoginModal() {
        const m = document.getElementById('loginModal');
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeLoginModal() {
        const m = document.getElementById('loginModal');
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    // Cerrar con Escape
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeLoginModal();
    });
</script>
