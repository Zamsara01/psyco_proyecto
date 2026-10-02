<!-- ═══════════════════════════════════════════════════════════
     MODAL OLVIDÉ MI CONTRASEÑA
     ═══════════════════════════════════════════════════════════ -->

<div id="forgotPasswordModal"
     class="fixed inset-0 z-[60] hidden items-center justify-center p-4 transition-all duration-300"
     role="dialog" aria-modal="true">

    <!-- Backdrop -->
    <div class="absolute inset-0 bg-slate-900/40 dark:bg-slate-900/60 backdrop-blur-sm" onclick="closeForgotPasswordModal()"></div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-md bg-white dark:bg-slate-800 rounded-3xl shadow-2xl border border-slate-100 dark:border-slate-700 overflow-hidden transform scale-95 opacity-0 transition-all duration-300" id="forgotPasswordBox">
        
        <!-- Botón cerrar -->
        <button type="button" onclick="closeForgotPasswordModal()"
                class="absolute top-4 right-4 w-8 h-8 flex items-center justify-center rounded-full bg-slate-100 dark:bg-slate-700 text-slate-500 dark:text-slate-400 hover:bg-slate-200 dark:hover:bg-slate-600 transition-colors">
            <span class="material-symbols-outlined text-[20px]">close</span>
        </button>

        <div class="pt-8 px-8 pb-4 text-center border-b border-slate-100 dark:border-slate-700">
            <div class="w-16 h-16 bg-blue-50 dark:bg-blue-900/30 rounded-full flex items-center justify-center mx-auto mb-4">
                <span class="material-symbols-outlined text-[32px] text-blue-600 dark:text-blue-400">lock_reset</span>
            </div>
            <h2 class="text-xl font-bold text-slate-800 dark:text-slate-100 mb-2">Restablecer contraseña</h2>
            <p class="text-sm text-slate-500 dark:text-slate-400" id="fpDesc">
                Ingresa tu correo electrónico y te enviaremos un código para cambiar tu contraseña.
            </p>
        </div>

        <div class="p-8">
            <!-- Paso 1: Pedir Correo -->
            <div id="fpStep1">
                <div class="space-y-1.5 mb-6">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-300" for="fpEmail">Correo electrónico</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[20px] text-slate-400 pointer-events-none select-none" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 20">mail</span>
                        <input id="fpEmail" type="email" placeholder="ejemplo@correo.com"
                               class="w-full pl-10 pr-4 h-11 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 dark:text-slate-100 outline-none"
                               style="color-scheme: light dark; --placeholder-color: #94a3b8;"
                        />
                    </div>
                </div>
                <button type="button" onclick="enviarCodigoFp()" id="btnSendFp"
                        class="w-full h-11 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                    <span>Enviar código</span>
                    <span class="material-symbols-outlined text-[18px]" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 20">send</span>
                </button>
            </div>

            <!-- Paso 2: OTP y Nueva Contraseña -->
            <div id="fpStep2" class="hidden space-y-4">
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-300" for="fpCode">Código de verificación (6 dígitos)</label>
                    <input id="fpCode" type="text" placeholder="000000" maxlength="6"
                           class="w-full text-center tracking-[0.5em] font-mono text-xl h-12 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 dark:text-slate-100 outline-none"/>
                </div>
                
                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-300" for="fpNewPass">Nueva contraseña</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[20px] text-slate-400 pointer-events-none select-none" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 20">lock</span>
                        <input id="fpNewPass" type="password" placeholder="Mínimo 8 caracteres"
                               class="w-full pl-10 pr-4 h-11 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 dark:text-slate-100 outline-none"/>
                    </div>
                </div>

                <div class="space-y-1.5">
                    <label class="text-sm font-medium text-slate-600 dark:text-slate-300" for="fpNewPassConfirm">Confirmar contraseña</label>
                    <div class="relative flex items-center">
                        <span class="material-symbols-outlined absolute left-3 text-[20px] text-slate-400 pointer-events-none select-none" style="font-variation-settings:'FILL' 0,'wght' 400,'GRAD' 0,'opsz' 20">lock</span>
                        <input id="fpNewPassConfirm" type="password" placeholder="Repite la contraseña"
                               class="w-full pl-10 pr-4 h-11 bg-white dark:bg-slate-900 border border-slate-300 dark:border-slate-600 rounded-xl focus:ring-2 focus:ring-blue-500/20 focus:border-blue-500 transition-all text-slate-800 dark:text-slate-100 outline-none"/>
                    </div>
                </div>

                <button type="button" onclick="cambiarPasswordFp()" id="btnChangeFp"
                        class="w-full h-11 mt-2 bg-blue-600 hover:bg-blue-700 text-white font-bold rounded-xl shadow-md transition-all flex items-center justify-center gap-2">
                    <span>Cambiar contraseña</span>
                    <span class="material-symbols-outlined text-[18px]">check_circle</span>
                </button>
            </div>

            <!-- Alertas -->
            <div id="fpAlert" class="hidden mt-4 p-3 rounded-lg text-sm flex items-center gap-2"></div>

            <div class="mt-6 text-center border-t border-slate-100 dark:border-slate-700 pt-4">
                <button type="button" onclick="closeForgotPasswordModal(); openLoginModal();" class="text-sm text-slate-500 hover:text-blue-600 dark:hover:text-blue-400 font-medium transition-colors">
                    Volver a iniciar sesión
                </button>
            </div>
        </div>
    </div>
</div>

<style>
#forgotPasswordModal input::placeholder {
    color: #94a3b8 !important;
    opacity: 1 !important;
}
#forgotPasswordModal .dark input::placeholder,
.dark #forgotPasswordModal input::placeholder {
    color: #64748b !important;
    opacity: 1 !important;
}
</style>

<script>
    function openForgotPasswordModal() {
        const m = document.getElementById('forgotPasswordModal');
        const box = document.getElementById('forgotPasswordBox');
        
        // Reset UI
        document.getElementById('fpStep1').classList.remove('hidden');
        document.getElementById('fpStep2').classList.add('hidden');
        document.getElementById('fpDesc').textContent = 'Ingresa tu correo electrónico y te enviaremos un código para cambiar tu contraseña.';
        document.getElementById('fpEmail').value = '';
        document.getElementById('fpCode').value = '';
        document.getElementById('fpNewPass').value = '';
        document.getElementById('fpNewPassConfirm').value = '';
        document.getElementById('fpAlert').className = 'hidden mt-4 p-3 rounded-lg text-sm flex items-center gap-2';
        
        m.classList.remove('hidden');
        m.classList.add('flex');
        setTimeout(() => {
            box.classList.remove('scale-95', 'opacity-0');
            box.classList.add('scale-100', 'opacity-100');
        }, 10);
        document.body.style.overflow = 'hidden';
    }

    function closeForgotPasswordModal() {
        const m = document.getElementById('forgotPasswordModal');
        const box = document.getElementById('forgotPasswordBox');
        box.classList.remove('scale-100', 'opacity-100');
        box.classList.add('scale-95', 'opacity-0');
        setTimeout(() => {
            m.classList.add('hidden');
            m.classList.remove('flex');
        }, 300);
        document.body.style.overflow = '';
    }

    function showFpAlert(msg, isError = true) {
        const alert = document.getElementById('fpAlert');
        alert.className = `mt-4 p-3 rounded-lg text-sm flex items-start gap-2 ${
            isError ? 'bg-red-50 text-red-700 dark:bg-red-900/30 dark:text-red-400' 
                    : 'bg-green-50 text-green-700 dark:bg-green-900/30 dark:text-green-400'
        }`;
        alert.innerHTML = `<span class="material-symbols-outlined text-[18px] shrink-0 mt-0.5">${isError ? 'error' : 'check_circle'}</span><span>${msg}</span>`;
    }

    async function enviarCodigoFp() {
        const email = document.getElementById('fpEmail').value.trim();
        if (!email) { showFpAlert('Ingresa tu correo electrónico.'); return; }
        
        const btn = document.getElementById('btnSendFp');
        btn.disabled = true;
        btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span><span>Enviando...</span>`;
        
        try {
            const fd = new FormData();
            fd.append('email', email);
            const res = await fetch('<?= URL_BASE ?>users/requestPasswordReset', { method: 'POST', body: fd });
            const data = await res.json();
            
            if (data.ok) {
                document.getElementById('fpStep1').classList.add('hidden');
                document.getElementById('fpStep2').classList.remove('hidden');
                document.getElementById('fpDesc').textContent = 'Ingresa el código que enviamos a tu correo y tu nueva contraseña.';
                showFpAlert('Código enviado con éxito.', false);
            } else {
                showFpAlert(data.error || 'Ocurrió un error.');
            }
        } catch (e) {
            showFpAlert('Error de conexión.');
        }
        
        btn.disabled = false;
        btn.innerHTML = `<span>Enviar código</span><span class="material-symbols-outlined text-[18px]">send</span>`;
    }

    async function cambiarPasswordFp() {
        const email = document.getElementById('fpEmail').value.trim();
        const code = document.getElementById('fpCode').value.trim();
        const pass = document.getElementById('fpNewPass').value;
        const confirm = document.getElementById('fpNewPassConfirm').value;
        
        if (!code || !pass || !confirm) { showFpAlert('Llena todos los campos.'); return; }
        if (pass !== confirm) { showFpAlert('Las contraseñas no coinciden.'); return; }
        if (pass.length < 8) { showFpAlert('La contraseña debe tener al menos 8 caracteres.'); return; }
        
        const btn = document.getElementById('btnChangeFp');
        btn.disabled = true;
        btn.innerHTML = `<span class="material-symbols-outlined animate-spin text-[18px]">progress_activity</span><span>Cambiando...</span>`;
        
        try {
            const fd = new FormData();
            fd.append('email', email);
            fd.append('code', code);
            fd.append('password', pass);
            const res = await fetch('<?= URL_BASE ?>users/resetPassword', { method: 'POST', body: fd });
            const data = await res.json();
            
            if (data.ok) {
                showFpAlert('Contraseña cambiada con éxito.', false);
                document.getElementById('fpStep2').classList.add('hidden');
                setTimeout(() => {
                    closeForgotPasswordModal();
                    openLoginModal();
                }, 2000);
            } else {
                showFpAlert(data.error || 'Ocurrió un error al cambiar la contraseña.');
            }
        } catch (e) {
            showFpAlert('Error de conexión.');
        }
        
        btn.disabled = false;
        btn.innerHTML = `<span>Cambiar contraseña</span><span class="material-symbols-outlined text-[18px]">check_circle</span>`;
    }
</script>
