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
                <img alt="PSYCO Logo" class="w-full h-full object-contain" src="https://lh3.googleusercontent.com/aida/ADBb0uiOUkpR-uX3pbcr8qDf7NFfp2MBKT1SRByOafvSaVtpiJa9HzfBx5Kd4UqqFg7ZPLd3JNhgcr1AJzM0at1DuOGU-2JbtkpuWI1-xy1KUMxcM5z_wxCWXCqtQk3VpMYJvMyqZC6QAB_Q5r71C6EBs2Us9lvMjBoQJvJO7_eNlvAUBNGFfyzTv_GWJ0dr_yDABQ3eVEQhU78Jnk43iFXaMl3SZQA64lpcA-fvSWoj_HhCMx1oubWNLJSQjdVaSxoB0I5-LpY93PC0gwQ"/>
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
        
        <!-- Footer Links (dejados a petición del usuario) -->
        <div class="px-stack-lg pb-stack-lg pt-2 flex flex-col gap-4">
            <div class="flex items-center gap-4">
                <div class="h-[1px] flex-grow bg-outline-variant/30"></div>
                <span class="font-label-md text-label-md text-tertiary">O</span>
                <div class="h-[1px] flex-grow bg-outline-variant/30"></div>
            </div>
            <div class="flex flex-col sm:flex-row items-center justify-between gap-4">
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
