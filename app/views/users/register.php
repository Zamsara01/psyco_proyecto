<!-- Main Content Canvas -->
<main class="flex-grow py-12 px-6 flex justify-center items-center w-full z-10 relative">
    
    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-primary/5 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] rounded-full bg-orange-600/5 blur-3xl"></div>
    </div>

    <div class="w-full max-w-xl bg-white rounded-xl shadow-sm overflow-hidden border border-slate-100 p-8 md:p-12 relative">
        <div class="max-w-md mx-auto">
            <header class="mb-8">
                <!-- Color Logo placed in the top left corner above the form content -->
                <div class="mb-8 flex justify-center">
                    <img alt="PSYCO Logo" class="h-40 w-auto" src="https://lh3.googleusercontent.com/aida/ADBb0uivEcdTeZh4LjML8Ap7wbSuN9wbOw89eAAkqN984qdDhtCcCAE3Es24NSAW0PSl5VbkebWMx7McT4tIXaFox5bFYxc66vOq4vAIdD-tuoxoDYWLtGdYuiy06Gu4ZE-qKSM-IMVA74ytUhD1FFEEnJp5rysbCpSCjHtADiQauc4pHgpC_byKfG2gmVHKI8l_c5_DhqAfssNScXbthM0ts-T8-B9gX5GYaVFzKqNpz13i5Iqb-0_x629qd44dLVWjA5FaWY_4vf1xYg"/>
                </div>
                <h1 class="text-headline-md font-headline-md text-on-surface">Crear una cuenta</h1>
                <p class="text-body-md font-body-md text-tertiary mt-2">Completa tus datos para registrarte en PSYCO.</p>
            </header>

            <form class="space-y-5" method="POST" action="<?= URL_BASE ?>users/store">
                <!-- Perfil por defecto, oculto -->
                <input type="hidden" name="txtperfil" value="usuario">

                <!-- Nombre Completo -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputNombre">Nombre Completo</label>
                    <input class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                           id="inputNombre" name="txtnombre" placeholder="Ej. Juan Pérez" type="text" required/>
                </div>

                <!-- Correo Electrónico -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputEmail">Correo electrónico</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-tertiary">mail</span>
                        <input class="w-full pl-10 pr-4 h-12 bg-surface-container-low border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                               id="inputEmail" name="txtEmail" placeholder="usuario@ejemplo.com" type="email" required/>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputPassword">Contraseña</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-tertiary">lock</span>
                        <input class="w-full pl-10 pr-12 h-12 bg-surface-container-low border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                               id="inputPassword" name="txtPassword" placeholder="••••••••" type="password" required/>
                    </div>
                </div>

                <!-- Privacy Policy -->
                <div class="flex items-start gap-3 py-2 mt-4">
                    <input class="mt-1 rounded border-slate-300 text-primary focus:ring-primary" id="terms" type="checkbox" required/>
                    <label class="text-body-sm text-tertiary" for="terms">Acepto los <a class="text-orange-600 font-medium hover:underline" href="#">términos de servicio</a> y la <a class="text-orange-600 font-medium hover:underline" href="#">política de privacidad</a>.</label>
                </div>

                <!-- Submit Button -->
                <button class="w-full h-14 bg-primary text-on-primary font-bold text-headline-sm rounded-xl shadow-lg shadow-primary/20 hover:bg-on-primary-fixed-variant transition-all transform active:scale-[0.98] flex items-center justify-center gap-2 mt-4" type="submit">
                    Registrarse
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <footer class="mt-8 text-center">
                <p class="text-body-md text-tertiary">
                    ¿Ya tienes una cuenta? 
                    <a class="text-orange-600 font-bold hover:underline" href="<?= URL_BASE ?>users/login">Inicia sesión</a>
                </p>
            </footer>
        </div>
    </div>
</main>
