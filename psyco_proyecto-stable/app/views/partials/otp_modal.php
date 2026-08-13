<!-- ═══════════════════════════════════════════════════════════
     MODAL DE VERIFICACIÓN OTP
     Aparece automáticamente cuando hay un registro pendiente
     ═══════════════════════════════════════════════════════════ -->

<div id="otpModal"
     class="fixed inset-0 z-50 flex items-center justify-center p-4"
     role="dialog" aria-modal="true" aria-labelledby="otpModalTitle">

    <!-- Backdrop (No cierra el modal para obligar a verificar) -->
    <div class="absolute inset-0 bg-black/60 backdrop-blur-sm"></div>

    <!-- Card -->
    <div class="relative z-10 w-full max-w-md bg-white rounded-2xl shadow-2xl overflow-hidden animate-[fadeInScale_0.3s_ease-out]">
        
        <!-- Header -->
        <div class="pt-8 px-8 flex flex-col items-center border-b border-slate-100 pb-6">
            <div class="w-16 h-16 bg-primary/10 rounded-full flex items-center justify-center mb-4">
                <span class="material-symbols-outlined text-[32px] text-primary">mark_email_read</span>
            </div>
            <h2 id="otpModalTitle" class="font-headline-sm text-headline-sm text-on-surface text-center mb-2">Verifica tu correo electrónico</h2>
            <p class="font-body-sm text-body-sm text-on-surface-variant text-center">
                Hemos enviado un código de verificación de 6 dígitos a:
            </p>
            <p class="font-label-lg text-label-lg text-primary text-center mt-1 font-bold">
                <?= htmlspecialchars($_SESSION['temp_user_email'] ?? '') ?>
            </p>
        </div>

        <div class="p-8 bg-surface-container-lowest">
            <p class="font-body-sm text-body-sm text-on-surface-variant text-center mb-6">
                Para completar tu registro, revisa tu correo electrónico e ingresa el código recibido.
            </p>

            <?php if (!empty($_SESSION['otp_error'])): ?>
                <div class="mb-6 bg-error-container text-on-error-container p-3 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">error</span>
                    <span class="font-body-sm text-sm"><?= htmlspecialchars($_SESSION['otp_error']) ?></span>
                </div>
                <?php unset($_SESSION['otp_error']); ?>
            <?php endif; ?>

            <?php if (!empty($_SESSION['otp_success'])): ?>
                <div class="mb-6 bg-green-50 text-green-700 p-3 rounded-lg flex items-center gap-2">
                    <span class="material-symbols-outlined text-[20px]">check_circle</span>
                    <span class="font-body-sm text-sm"><?= htmlspecialchars($_SESSION['otp_success']) ?></span>
                </div>
                <?php unset($_SESSION['otp_success']); ?>
            <?php endif; ?>

            <form class="space-y-6" method="POST" action="<?= URL_BASE ?>users/verifyOtp">
                <div>
                    <label for="codigoOtp" class="sr-only">Código OTP</label>
                    <input id="codigoOtp" name="codigo" type="text" required 
                           class="w-full h-14 bg-surface-container-low border border-slate-200 rounded-xl text-center text-2xl tracking-[0.5em] font-mono focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all outline-none text-on-surface placeholder:tracking-normal placeholder:text-lg" 
                           placeholder="000000" maxlength="6" pattern="\d{6}" autocomplete="off">
                </div>

                <button type="submit" 
                        class="w-full h-12 bg-primary text-on-primary font-bold rounded-xl shadow-lg shadow-primary/20 hover:opacity-90 active:scale-[0.98] transition-all flex items-center justify-center gap-2">
                    Verificar código
                    <span class="material-symbols-outlined">verified</span>
                </button>
            </form>

            <div class="mt-6 flex flex-col items-center gap-4 border-t border-slate-100 pt-6">
                <p class="text-xs text-tertiary text-center px-4 bg-orange-50 border border-orange-100 p-2 rounded-lg text-orange-800">
                    <span class="material-symbols-outlined text-[16px] inline-block align-middle mr-1">info</span>
                    Si no encuentras el mensaje en tu bandeja principal, revisa tu carpeta de spam o correo no deseado.
                </p>
                <form method="POST" action="<?= URL_BASE ?>users/resendOtp" class="w-full">
                    <button type="submit" class="w-full text-primary font-label-md hover:underline bg-transparent border-none cursor-pointer flex items-center justify-center gap-1">
                        <span class="material-symbols-outlined text-[18px]">send</span>
                        Reenviar código
                    </button>
                </form>
            </div>
            
            <div class="mt-4 text-center">
                <a href="<?= URL_BASE ?>users/logout" class="text-xs text-slate-400 hover:text-slate-600 hover:underline transition-colors">
                    Usar otro correo / Cancelar registro
                </a>
            </div>
        </div>
    </div>
</div>
