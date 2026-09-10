<!-- Main Content Canvas -->
<main class="flex-grow py-12 px-6 flex justify-center items-center w-full z-10 relative">
    
    <!-- Background Decorative Elements -->
    <div class="fixed inset-0 overflow-hidden pointer-events-none -z-10">
        <div class="absolute top-[-10%] right-[-10%] w-[500px] h-[500px] rounded-full bg-[#2563eb]/10 blur-3xl"></div>
        <div class="absolute bottom-[-10%] left-[-10%] w-[400px] h-[400px] rounded-full bg-[#16a34a]/10 blur-3xl"></div>
    </div>

    <div class="w-full max-w-xl bg-white/80 backdrop-blur-md rounded-xl shadow-lg overflow-hidden border border-white/60 p-8 md:p-12 relative">
        <div class="max-w-md mx-auto">
            <header class="mb-8">
                <!-- Color Logo placed in the top left corner above the form content -->
                <div class="mb-8 flex justify-center">
                    <img alt="PSYCO Logo" class="h-16 w-auto" src="<?= URL_BASE ?>public/img/psyco.png"/>
                </div>
                <h1 class="text-headline-md font-headline-md text-on-surface">Crear una cuenta</h1>
                <p class="text-body-md font-body-md text-tertiary mt-2">Completa tus datos para registrarte en PSYCO.</p>
            </header>

            <form class="space-y-5" method="POST" action="<?= URL_BASE ?>users/store">
                <!-- Perfil por defecto, oculto -->
                <input type="hidden" name="txtperfil" value="usuario">

                <!-- Grado -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputGrado">Grado</label>
                    <select class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                            id="inputGrado" name="txtgrado" required>
                        <option value="" disabled selected>Selecciona tu grado</option>
                        <option value="6">6</option>
                        <option value="7">7</option>
                        <option value="8">8</option>
                        <option value="9">9</option>
                        <option value="10">10</option>
                        <option value="11">11</option>
                    </select>
                </div>

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
                        <button type="button" onclick="const p = document.getElementById('inputPassword'); p.type = p.type === 'password' ? 'text' : 'password'; this.innerText = p.type === 'password' ? 'visibility_off' : 'visibility';" class="material-symbols-outlined absolute right-3 text-tertiary hover:text-on-surface transition-colors focus:outline-none">visibility_off</button>
                    </div>
                </div>

                <!-- Confirmar Contraseña -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputPassword2">Confirmar Contraseña</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-tertiary">lock</span>
                        <input class="w-full pl-10 pr-12 h-12 bg-surface-container-low border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                               id="inputPassword2" name="txtPassword2" placeholder="••••••••" type="password" required/>
                        <button type="button" onclick="const p = document.getElementById('inputPassword2'); p.type = p.type === 'password' ? 'text' : 'password'; this.innerText = p.type === 'password' ? 'visibility_off' : 'visibility';" class="material-symbols-outlined absolute right-3 text-tertiary hover:text-on-surface transition-colors focus:outline-none">visibility_off</button>
                    </div>
                </div>

                <!-- Política de Tratamiento de Datos -->
                <div class="space-y-3 pt-2">
                    <label class="text-label-md font-label-md text-on-surface-variant block leading-relaxed">
                        ¿Acepta la política de tratamiento de datos para su historial clínico de forma digital?
                    </label>
                    <div class="flex gap-4">
                        <label class="flex items-center gap-2 cursor-pointer text-body-md text-on-surface">
                            <input type="radio" name="acepta_politica" value="si" class="text-primary focus:ring-primary h-4 w-4" onchange="togglePoliticaData(this.value)" required>
                            Sí
                        </label>
                        <label class="flex items-center gap-2 cursor-pointer text-body-md text-on-surface">
                            <input type="radio" name="acepta_politica" value="no" class="text-primary focus:ring-primary h-4 w-4" onchange="togglePoliticaData(this.value)" required>
                            No
                        </label>
                    </div>

                    <!-- Sección Sí -->
                    <div id="section_politica_si" class="hidden space-y-4 pt-4 border-t border-slate-200 mt-2">
                        <div class="space-y-1.5">
                            <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputAcudiente">Nombre del acudiente</label>
                            <input class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                                   id="inputAcudiente" name="txtacudiente" placeholder="Ej. María López" type="text" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputCedula">Número de cédula del acudiente</label>
                            <input class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                                   id="inputCedula" name="txtcedula" placeholder="Ej. 1234567890"
                                   type="tel" inputmode="numeric" pattern="[0-9]+"
                                   oninput="this.value = this.value.replace(/[^0-9]/g, '');"
                                   title="Solo se permiten números" />
                            <p id="cedulaError" class="hidden text-xs text-red-500 font-medium flex items-center gap-1 mt-1">
                                <span class="material-symbols-outlined text-[14px]">error</span>
                                La cédula solo puede contener números.
                            </p>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputRelacion">Relación con el estudiante</label>
                            <select class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                                    id="inputRelacion" name="txtrelacion">
                                <option value="" disabled selected>Selecciona una relación</option>
                                <option value="padre">Padre</option>
                                <option value="madre">Madre</option>
                                <option value="tutor">Tutor(a)</option>
                            </select>
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputCorreoAcudiente">Correo electrónico del acudiente</label>
                            <input class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md" 
                                   id="inputCorreoAcudiente" name="txtcorreo_acudiente" placeholder="Ej. correo@ejemplo.com" type="email" />
                        </div>
                        <div class="flex items-start gap-3 py-2 mt-2">
                            <input class="mt-1 rounded border-slate-300 text-primary focus:ring-primary" id="checkDatos" name="checkDatos" type="checkbox"/>
                            <label class="text-body-sm text-tertiary" for="checkDatos">
                                Acepto explícitamente que mis datos personales (nombre, cédula y relación con el estudiante) y el historial clínico del estudiante sean recopilados, almacenados y procesados de forma digital exclusivamente para fines de seguimiento psicológico y logístico.
                            </label>
                        </div>
                    </div>

                    <!-- Sección No -->
                    <div id="section_politica_no" class="hidden pt-2">
                        <p class="text-body-sm text-orange-800 bg-orange-50 p-3 rounded-lg border border-orange-200">
                            La psicóloga encargada aún puede tomar apuntes sobre la cita en presencial o por formatos físicos o de papelería por motivos de logística en la psicología.
                        </p>
                    </div>
                </div>

                <!-- Privacy Policy -->
                <div class="flex items-start gap-3 py-2 mt-4">
                    <input class="mt-1 rounded border-slate-300 text-primary focus:ring-primary" id="terms" type="checkbox" required/>
                    <label class="text-body-sm text-tertiary" for="terms">Acepto los <a class="text-green-600 font-medium hover:underline cursor-pointer" href="#" onclick="openTermsModal(event)">términos y condiciones generales</a>.</label>
                </div>

                <!-- Submit Button -->
                <button class="w-full h-14 bg-green-600 text-white font-bold text-headline-sm rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all transform active:scale-[0.98] flex items-center justify-center gap-2 mt-4" type="submit">
                    Registrarse
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <div class="mt-6 flex flex-col gap-4">
                <!-- Divisor con botón Google OAuth -->
                <div class="flex items-center gap-4">
                    <div class="h-[1px] flex-grow bg-slate-200"></div>
                    <span class="text-body-sm font-medium text-tertiary">O regístrate con</span>
                    <div class="h-[1px] flex-grow bg-slate-200"></div>
                </div>

                <!-- Botón Google -->
                <a id="btnGoogleRegister"
                   href="<?= URL_BASE ?>auth/google"
                   class="w-full flex items-center justify-center gap-3
                          bg-white border border-slate-200
                          hover:bg-slate-50 hover:border-slate-300
                          active:scale-[0.98] transition-all duration-200
                          py-3 px-4 rounded-lg shadow-sm">

                    <!-- Logo SVG de Google -->
                    <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 48 48" width="22" height="22">
                        <path fill="#4285F4" d="M45.12 24.5c0-1.57-.14-3.08-.4-4.53H24v8.57h11.86c-.51 2.75-2.06 5.08-4.39 6.64v5.52h7.11c4.16-3.83 6.54-9.47 6.54-16.2z"/>
                        <path fill="#34A853" d="M24 46c5.94 0 10.92-1.97 14.56-5.33l-7.11-5.52c-1.97 1.32-4.49 2.1-7.45 2.1-5.73 0-10.58-3.87-12.32-9.07H4.34v5.7C7.96 41.07 15.4 46 24 46z"/>
                        <path fill="#FBBC05" d="M11.68 28.18A13.8 13.8 0 0 1 10.8 24c0-1.45.25-2.86.68-4.18v-5.7H4.34A22.03 22.03 0 0 0 2 24c0 3.55.85 6.91 2.34 9.88l7.34-5.7z"/>
                        <path fill="#EA4335" d="M24 10.75c3.23 0 6.13 1.11 8.41 3.29l6.31-6.31C34.91 4.18 29.93 2 24 2 15.4 2 7.96 6.93 4.34 14.12l7.34 5.7C13.42 14.62 18.27 10.75 24 10.75z"/>
                    </svg>

                    <span class="text-body-md text-on-surface font-semibold">
                        Continuar con Google
                    </span>
                </a>
            </div>

            <script>
                function togglePoliticaData(value) {
                    const sectionSi = document.getElementById('section_politica_si');
                    const sectionNo = document.getElementById('section_politica_no');
                    const checkDatos = document.getElementById('checkDatos');
                    const inputAcudiente = document.getElementById('inputAcudiente');
                    const inputCedula = document.getElementById('inputCedula');
                    const inputRelacion = document.getElementById('inputRelacion');
                    const inputCorreoAcudiente = document.getElementById('inputCorreoAcudiente');
                    
                    if (value === 'si') {
                        sectionSi.classList.remove('hidden');
                        sectionNo.classList.add('hidden');
                        checkDatos.setAttribute('required', 'required');
                        inputAcudiente.setAttribute('required', 'required');
                        inputCedula.setAttribute('required', 'required');
                        inputRelacion.setAttribute('required', 'required');
                        inputCorreoAcudiente.setAttribute('required', 'required');
                    } else {
                        sectionSi.classList.add('hidden');
                        sectionNo.classList.remove('hidden');
                        checkDatos.removeAttribute('required');
                        inputAcudiente.removeAttribute('required');
                        inputCedula.removeAttribute('required');
                        inputRelacion.removeAttribute('required');
                        inputCorreoAcudiente.removeAttribute('required');
                    }
                }
            </script>

            <footer class="mt-8 text-center">
                <p class="text-body-md text-tertiary">
                    ¿Ya tienes una cuenta? 
                    <a class="text-orange-600 font-bold hover:underline" href="<?= URL_BASE ?>users/login">Inicia sesión</a>
                </p>
            </footer>
        </div>
    </div>
</main>
