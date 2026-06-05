<!-- Login Card Container -->
<main class="flex-grow flex items-center justify-center p-container-margin relative z-10 w-full">
    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-primary/5 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] rounded-full bg-secondary/5 blur-3xl"></div>
    </div>
    
    <div class="w-full max-w-md bg-surface-container-lowest rounded-xl shadow-sm border border-outline-variant/30 overflow-hidden transition-all duration-300 hover:shadow-md">
        <!-- Logo Header -->
        <div class="pt-stack-lg px-stack-lg flex flex-col items-center">
            <div class="w-24 h-24 mb-stack-md flex items-center justify-center overflow-hidden">
                <img alt="PSYCO Logo" class="w-full h-full object-contain" src="<?= URL_BASE ?>public/img/psyco.png"/>
            </div>
            <h1 class="font-headline-md text-headline-md text-on-surface text-center mb-stack-sm">Bienvenido de nuevo</h1>
            <p class="font-body-sm text-body-sm text-tertiary text-center">Inicia sesión para gestionar tus recursos y horarios.</p>
        </div>
        
        <?php if (!empty($error)): ?>
            <div class="mx-stack-lg mt-stack-md bg-error-container text-on-error-container p-3 rounded-lg flex items-center gap-2">
                <span class="material-symbols-outlined">error</span>
                <span class="font-body-sm"><?= htmlspecialchars($error) ?></span>
            </div>
        <?php endif; ?>

        <!-- Form Section -->
        <form class="p-stack-lg space-y-stack-md" method="POST" action="<?= URL_BASE ?>users/authenticate">
            <!-- Email -->
            <div class="space-y-2">
                <label class="font-label-md text-label-md text-on-surface-variant ml-1" for="inputEmail">Correo Electrónico</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-tertiary">mail</span>
                    <input class="w-full pl-10 pr-4 py-3 bg-surface-container-low border-transparent border-b-2 border-b-surface-variant focus:border-b-primary focus:ring-0 focus:bg-surface-container rounded-t-lg font-body-md text-body-md transition-all outline-none" 
                           id="inputEmail" name="txtEmail" placeholder="ejemplo@correo.com" type="email" required/>
                </div>
            </div>

            <!-- Password -->
            <div class="space-y-2">
                <label class="font-label-md text-label-md text-on-surface-variant ml-1" for="inputPassword">Contraseña</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-3 text-tertiary">lock</span>
                    <input class="w-full pl-10 pr-12 py-3 bg-surface-container-low border-transparent border-b-2 border-b-surface-variant focus:border-b-primary focus:ring-0 focus:bg-surface-container rounded-t-lg font-body-md text-body-md transition-all outline-none" 
                           id="inputPassword" name="txtPassword" placeholder="••••••••" type="password" required/>
                </div>
            </div>
            
            <!-- Submit Button (Usando Verde unificado) -->
            <div class="pt-stack-md">
                <button type="submit" class="w-full bg-primary text-on-primary py-4 rounded-lg font-headline-sm text-headline-sm shadow-sm hover:shadow-md hover:bg-on-primary-fixed-variant active:scale-[0.98] transition-all duration-200 flex items-center justify-center gap-2">
                    Iniciar Sesión
                    <span class="material-symbols-outlined">login</span>
                </button>
            </div>
        </form>
        
        <!-- Footer Links -->
        <div class="px-stack-lg pb-stack-lg pt-2 flex flex-col gap-4">

            <!-- Divisor con botón Google OAuth -->
            <div class="flex items-center gap-4">
                <div class="h-[1px] flex-grow bg-outline-variant/30"></div>
                <span class="font-label-md text-label-md text-tertiary">O continúa con</span>
                <div class="h-[1px] flex-grow bg-outline-variant/30"></div>
            </div>

            <!-- Botón Google -->
            <a id="btnGoogleLogin"
               href="<?= URL_BASE ?>auth/google"
               class="w-full flex items-center justify-center gap-3
                      bg-surface-container-lowest border border-outline-variant/50
                      hover:bg-surface-container hover:border-primary/40
                      active:scale-[0.98] transition-all duration-200
                      py-3 px-4 rounded-lg shadow-sm hover:shadow-md">

                <!-- Logo SVG de Google (sin dependencias externas) -->
                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22">
                    <path fill="#4285F4" d="M45.12 24.5c0-1.57-.14-3.08-.4-4.53H24v8.57h11.86c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.54-9.47 6.54-16.2z"/>
                    <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.32-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>
                    <path fill="#FBBC05" d="M11.68 28.18A13.8 13.8 0 0 1 10.8 24c0-1.45.25-2.86.68-4.18v-5.7H4.34A22.03 22.03 0 0 0 2 24c0 3.55.85 6.91 2.34 9.88l7.34-5.7z"/>
                    <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.34 5.7C13.42 14.62 18.27 10.75 24 10.75z"/>
                </svg>

                <span class="font-label-lg text-on-surface font-semibold">
                    Continuar con Google
                </span>
            </a>

            <!-- Links secundarios -->
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4 pt-1">
                <a class="font-body-sm text-body-sm text-primary hover:underline transition-all" href="#">
                    Olvidé mi contraseña
                </a>
                <a class="font-body-sm text-body-sm text-orange-600 font-semibold hover:text-orange-700 transition-all" href="<?= URL_BASE ?>users/register">
                    ¿No tienes una cuenta? Regístrate
                </a>
            </div>
        </div>
    </div>
</main>
