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
<section class="oauth-error-wrapper">
    <div class="oauth-error-card">

        <div class="oauth-error-icon">
            <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 24 24"
                 fill="none" stroke="currentColor" stroke-width="2"
                 stroke-linecap="round" stroke-linejoin="round">
                <circle cx="12" cy="12" r="10"/>
                <line x1="12" y1="8" x2="12" y2="12"/>
                <line x1="12" y1="16" x2="12.01" y2="16"/>
            </svg>
        </div>

        <h1 class="oauth-error-title">Error de autenticación</h1>
        <p class="oauth-error-msg"><?= htmlspecialchars($mensaje, ENT_QUOTES, 'UTF-8') ?></p>

        <?php if ($reason !== 'unknown'): ?>
            <p class="oauth-error-code">Código: <code><?= htmlspecialchars($reason, ENT_QUOTES, 'UTF-8') ?></code></p>
        <?php endif; ?>

        <div class="oauth-error-actions">
            <a href="<?= URL_BASE ?>users/login" class="btn-primary">
                Volver al inicio de sesión
            </a>
            <a href="<?= URL_BASE ?>auth/google" class="btn-google">
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

<style>
.oauth-error-wrapper {
    min-height: 80vh;
    display: flex;
    align-items: center;
    justify-content: center;
    padding: 2rem;
}
.oauth-error-card {
    background: #fff;
    border-radius: 1.25rem;
    box-shadow: 0 8px 40px rgba(0,0,0,.12);
    padding: 3rem 2.5rem;
    max-width: 480px;
    width: 100%;
    text-align: center;
}
.oauth-error-icon {
    width: 64px;
    height: 64px;
    border-radius: 50%;
    background: #fff0f0;
    display: flex;
    align-items: center;
    justify-content: center;
    margin: 0 auto 1.5rem;
    color: #e53e3e;
}
.oauth-error-icon svg { width: 32px; height: 32px; }
.oauth-error-title {
    font-size: 1.5rem;
    font-weight: 700;
    color: #1a202c;
    margin-bottom: .75rem;
}
.oauth-error-msg {
    color: #4a5568;
    line-height: 1.6;
    margin-bottom: 1rem;
}
.oauth-error-code {
    font-size: .8rem;
    color: #a0aec0;
    margin-bottom: 2rem;
}
.oauth-error-code code {
    background: #f7fafc;
    padding: .1rem .4rem;
    border-radius: .3rem;
}
.oauth-error-actions {
    display: flex;
    flex-direction: column;
    gap: .75rem;
}
.btn-primary {
    display: block;
    background: #667eea;
    color: #fff;
    padding: .75rem 1.5rem;
    border-radius: .75rem;
    text-decoration: none;
    font-weight: 600;
    transition: background .2s;
}
.btn-primary:hover { background: #5a67d8; }
.btn-google {
    display: flex;
    align-items: center;
    justify-content: center;
    gap: .6rem;
    background: #fff;
    border: 1.5px solid #d1d5db;
    color: #374151;
    padding: .75rem 1.5rem;
    border-radius: .75rem;
    text-decoration: none;
    font-weight: 600;
    transition: border-color .2s, background .2s;
}
.btn-google:hover { background: #f9fafb; border-color: #9ca3af; }
</style>
