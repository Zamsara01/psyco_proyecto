<!-- ═══════════════════════════════════════════════════════════
     MODAL DE REGISTRO — se incluye en el layout global
     Se abre con: openRegisterModal()
     ═══════════════════════════════════════════════════════════ -->

<!-- Overlay -->
<div id="registerModal"
     class="fixed inset-0 z-50 hidden flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="registerModalTitle">

    <!-- Backdrop -->
    <div id="registerModalBackdrop"
         class="absolute inset-0 bg-black/50 backdrop-blur-sm"
         onclick="closeRegisterModal()"></div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-xl bg-white rounded-2xl shadow-2xl border border-slate-100 overflow-hidden
                animate-[fadeInScale_0.2s_ease-out] flex flex-col max-h-[90vh]">

        <!-- Header Fijo -->
        <div class="flex-shrink-0 relative border-b border-slate-100 pt-6 pb-4 px-8 bg-white z-20">
            <button onclick="closeRegisterModal()"
                    class="absolute top-4 right-4 p-1.5 rounded-full text-slate-400 hover:bg-slate-100 hover:text-slate-700 transition-colors focus:outline-none"
                    aria-label="Cerrar">
                <span class="material-symbols-outlined text-[22px]">close</span>
            </button>
            <div class="flex justify-center mb-4">
                <img alt="PSYCO Logo" class="h-12 w-auto" src="<?= URL_BASE ?>public/img/psyco.png"/>
            </div>
            <h2 id="registerModalTitle" class="font-headline-md text-headline-md text-on-surface text-center">Crear una cuenta</h2>
            <p class="font-body-sm text-body-sm text-tertiary text-center mt-1">Completa tus datos para registrarte en PSYCO.</p>
        </div>

        <!-- Formulario (Scrollable) -->
        <div class="overflow-y-auto p-8 relative z-10">
            <form class="space-y-5" method="POST" action="<?= URL_BASE ?>users/store">
                <!-- Perfil por defecto, oculto -->
                <input type="hidden" name="txtperfil" value="usuario">

                <!-- Grado -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputGrado">Grado</label>
                    <select class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none" 
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
                    <input class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none" 
                           id="inputNombre" name="txtnombre" placeholder="Ej. Juan Pérez" type="text" required/>
                </div>

                <!-- Correo Electrónico -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputEmailR">Correo electrónico</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-tertiary">mail</span>
                        <input class="w-full pl-10 pr-4 h-12 bg-surface-container-low border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none" 
                               id="inputEmailR" name="txtEmail" placeholder="usuario@ejemplo.com" type="email" required/>
                    </div>
                </div>

                <!-- Contraseña -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputPasswordR">Contraseña</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-tertiary">lock</span>
                        <input class="w-full pl-10 pr-12 h-12 bg-surface-container-low border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none" 
                               id="inputPasswordR" name="txtPassword" placeholder="••••••••" type="password" required/>
                        <button type="button" onclick="const p = document.getElementById('inputPasswordR'); p.type = p.type === 'password' ? 'text' : 'password'; this.innerText = p.type === 'password' ? 'visibility_off' : 'visibility';" class="material-symbols-outlined absolute right-3 text-tertiary hover:text-on-surface transition-colors focus:outline-none">visibility_off</button>
                    </div>
                </div>

                <!-- Confirmar Contraseña -->
                <div class="space-y-1.5">
                    <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputPassword2">Confirmar Contraseña</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-tertiary">lock</span>
                        <input class="w-full pl-10 pr-12 h-12 bg-surface-container-low border border-slate-200 rounded-lg focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none" 
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
                            <input class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none" 
                                   id="inputAcudiente" name="txtacudiente" placeholder="Ej. María López" type="text" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputCedula">Número de cédula</label>
                            <input class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none" 
                                   id="inputCedula" name="txtcedula" placeholder="Ej. 1234567890" type="text" />
                        </div>
                        <div class="space-y-1.5">
                            <label class="text-label-md font-label-md text-on-surface-variant block uppercase tracking-wider" for="inputRelacion">Relación con el estudiante</label>
                            <select class="w-full h-12 bg-surface-container-low border border-slate-200 rounded-lg px-4 focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all text-body-md outline-none" 
                                    id="inputRelacion" name="txtrelacion">
                                <option value="" disabled selected>Selecciona una relación</option>
                                <option value="padre">Padre</option>
                                <option value="madre">Madre</option>
                                <option value="tutor">Tutor(a)</option>
                            </select>
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
                    <label class="text-body-sm text-tertiary" for="terms">Acepto los <a class="text-green-600 font-medium hover:underline" href="#">términos y condiciones generales</a>.</label>
                </div>

                <!-- Submit Button -->
                <button class="w-full h-14 bg-green-600 text-white font-bold text-headline-sm rounded-xl shadow-lg shadow-green-600/20 hover:bg-green-700 transition-all transform active:scale-[0.98] flex items-center justify-center gap-2 mt-4" type="submit">
                    Registrarse
                    <span class="material-symbols-outlined">arrow_forward</span>
                </button>
            </form>

            <footer class="mt-8 text-center border-t border-slate-100 pt-6">
                <p class="text-body-md text-tertiary">
                    ¿Ya tienes una cuenta? 
                    <button type="button" onclick="closeRegisterModal(); openLoginModal();" class="text-orange-600 font-bold hover:underline bg-transparent border-none cursor-pointer">Inicia sesión</button>
                </p>
            </footer>
        </div>
    </div>
</div>

<script>
    function openRegisterModal() {
        const m = document.getElementById('registerModal');
        m.classList.remove('hidden');
        m.classList.add('flex');
        document.body.style.overflow = 'hidden';
    }
    function closeRegisterModal() {
        const m = document.getElementById('registerModal');
        m.classList.add('hidden');
        m.classList.remove('flex');
        document.body.style.overflow = '';
    }
    document.addEventListener('keydown', e => {
        if (e.key === 'Escape') closeRegisterModal();
    });

    function togglePoliticaData(value) {
        const sectionSi = document.getElementById('section_politica_si');
        const sectionNo = document.getElementById('section_politica_no');
        const checkDatos = document.getElementById('checkDatos');
        const inputAcudiente = document.getElementById('inputAcudiente');
        const inputCedula = document.getElementById('inputCedula');
        const inputRelacion = document.getElementById('inputRelacion');
        
        if (value === 'si') {
            sectionSi.classList.remove('hidden');
            sectionNo.classList.add('hidden');
            checkDatos.setAttribute('required', 'required');
            inputAcudiente.setAttribute('required', 'required');
            inputCedula.setAttribute('required', 'required');
            inputRelacion.setAttribute('required', 'required');
        } else {
            sectionSi.classList.add('hidden');
            sectionNo.classList.remove('hidden');
            checkDatos.removeAttribute('required');
            inputAcudiente.removeAttribute('required');
            inputCedula.removeAttribute('required');
            inputRelacion.removeAttribute('required');
        }
    }
</script>
