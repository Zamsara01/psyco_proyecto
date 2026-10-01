<style>
#main-content {
    background-image: url('<?= URL_BASE ?>public/img/calendariobackground.jpeg') !important;
    background-size: cover !important;
    background-position: center !important;
    background-attachment: fixed !important;
}
#main-content::before {
    content: '';
    position: fixed;
    inset: 0;
    background: rgba(244, 247, 246, 0.55);
    pointer-events: none;
    z-index: 0;
}
.dark #main-content::before { background: rgba(15, 23, 42, 0.65); }
.glass-card {
    background: rgba(255,255,255,0.88) !important;
    backdrop-filter: blur(6px);
    border: 1px solid rgba(255,255,255,0.6);
}
</style>
<?php
/**
 * Vista: auth/error.php
 * Muestra un mensaje amigable cuando falla el flujo de Google OAuth.
 * Variable disponible:
 *   $reason  — código de error (string, ya saneado en el controlador)
 */

$mensajes = [
    'access_denied'  => 'Cancelaste el acceso con Google. Puedes intentarlo de nuevo o iniciar sesión con tu correo.',
    'missing_params' => 'La respuesta de Google fue incompleta. Por favor intenta de nuevo.',
    'server_error'   => 'Ocurrió un error interno al procesar tu inicio de sesión. Por favor intenta más tarde.',
    'not_registered' => 'No tienes una cuenta registrada con este correo electrónico. Por favor, regístrate primero.',
    'unknown'        => 'Se produjo un error inesperado durante el inicio de sesión con Google.',
];

$reason = $reason ?? 'unknown';
$mensaje = $mensajes[$reason] ?? $mensajes['unknown'];
?>
<section class="relative z-10 p-6 md:p-8 flex items-center justify-center min-h-[80vh] w-full">
    <div class="glass-card rounded-3xl p-8 md:p-12 shadow-lg max-w-lg w-full text-center">

        <div style="width:64px;height:64px;border-radius:50%;display:flex;align-items:center;justify-content:center;color:#8a4a4a;background:rgba(174,107,107,0.12);border:1px solid rgba(174,107,107,0.3);margin:0 auto 1.5rem;">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>

        <h1 class="text-2xl font-bold text-[#3a6a8a] mb-3">Error de autenticación</h1>
        <p class="text-slate-600 leading-relaxed mb-6"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>

        <?php if ($reason !== 'unknown'): ?>
            <p class="oauth-error-code">Código: <code><?= htmlspecialchars($reason, ENT_QUOTES, 'UTF-8') ?></code></p>
        <?php endif; ?>

        <div class="flex flex-col gap-3 mt-6">
            <a href="<?= URL_BASE ?>users/login" class="px-6 py-3 rounded-xl font-bold text-white transition-all hover:bg-[#5a7e9f]" style="background:#6B8CAE;">
                Volver al inicio de sesión
            </a>
            <a href="<?= URL_BASE ?>auth/google" class="px-6 py-3 rounded-xl font-bold transition-all flex items-center justify-center gap-2" style="color:#4a6e8a; background:rgba(107,140,174,0.15); border:1px solid rgba(107,140,174,0.3); hover:background:rgba(107,140,174,0.25);">
                <svg viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg" width="20" height="20">
                    <path fill="#4285F4" d="M22.56 12.25c0-.78-.07-1.53-.2-2.25H12v4.26h5.92c-.26 1.37-1.04 2.53-2.21 3.31v2.77h3.57c2.08-1.92 3.28-4.74 3.28-8.09z"/>
                    <path fill="#34A853" d="M12 23c2.97 0 5.46-.98 7.28-2.66l-3.57-2.77c-.98.66-2.23 1.06-3.71 1.06-2.86 0-5.29-1.93-6.16-4.53H2.18v2.84C3.99 20.53 7.7 23 12 23z"/>
                    <path fill="#FBBC05" d="M5.84 14.09c-.22-.66-.35-1.36-.35-2.09s.13-1.43.35-2.09V7.07H2.18C1.43 8.55 1 10.22 1 12s.43 3.45 1.18 4.93l3.66-2.84z"/>
                    <path fill="#EA4335" d="M12 5.38c1.62 0 3.06.56 4.21 1.64l3.15-3.15C17.45 2.09 14.97 1 12 1 7.7 1 3.99 3.47 2.18 7.07l3.66 2.84c.87-2.6 3.3-4.53 6.16-4.53z"/>
                </svg>
                Intentar con Google de nuevo
            </a>
        </div>
    </div>
</section>

