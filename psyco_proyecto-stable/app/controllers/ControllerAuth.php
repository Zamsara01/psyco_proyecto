<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
require_once dirname(__DIR__, 2) . '/core/GoogleOAuthService.php';
require_once dirname(__DIR__)    . '/models/UserModel.php';

/**
 * ControllerAuth
 *
 * Gestiona el flujo OAuth 2.0 con Google.
 *
 * Rutas:
 *   GET  /auth/google           → redirige al consentimiento de Google
 *   GET  /auth/googleCallback   → recibe el código y autentica al usuario
 *   GET  /auth/error            → muestra página de error OAuth
 */
class ControllerAuth extends Controller
{
    private GoogleOAuthService $oauthService;
    private UserModel $userModel;

    public function __construct()
    {
        $this->oauthService = new GoogleOAuthService();
        $this->userModel    = new UserModel();
    }

    // ──────────────────────────────────────────────────────────────
    //  PASO 1 — Iniciar el flujo: redirigir a Google
    // ──────────────────────────────────────────────────────────────

    /**
     * GET /auth/google
     * Genera la URL de autorización y redirige al usuario a Google.
     */
    public function google(): void
    {
        // Sesión debe estar activa (index.php ya hace session_start())
        $authUrl = $this->oauthService->getAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    }

    // ──────────────────────────────────────────────────────────────
    //  PASO 2 — Callback: Google nos devuelve el código
    // ──────────────────────────────────────────────────────────────

    /**
     * GET /auth/googleCallback
     * Google redirige aquí con ?code=...&state=...
     * (o con ?error=access_denied si el usuario canceló)
     */
    public function googleCallback(): void
    {
        // ── Verificar si el usuario canceló en Google ──────────────
        if (isset($_GET['error'])) {
            $this->redirect('auth/error?reason=' . urlencode($_GET['error']));
            return;
        }

        // ── Validar parámetros mínimos ─────────────────────────────
        $code  = $_GET['code']  ?? '';
        $state = $_GET['state'] ?? '';

        if (!$code || !$state) {
            $this->redirect('auth/error?reason=missing_params');
            return;
        }

        try {
            // ── Verificar CSRF state ───────────────────────────────
            $this->oauthService->validateState($state);

            // ── Intercambiar código por access_token ───────────────
            $accessToken = $this->oauthService->exchangeCode($code);

            // ── Obtener perfil del usuario ─────────────────────────
            $googleUser = $this->oauthService->getUserInfo($accessToken);

            // ── Buscar usuario en nuestra BD ────────────
            $user = $this->userModel->findByGoogle($googleUser);

            if (!$user) {
                $this->redirect('users/login?error=not_registered_google');
                return;
            }

            // ── Establecer sesión ──────────────────────────────────
            $_SESSION['user'] = [
                'id'              => $user['id_usuario'],
                'nombre'          => $user['nombre'],
                'correo'          => $user['correo_electronico'],
                'grado'           => $user['grado']   ?? null,
                'estado'          => $user['estado'],
                'rol'             => 'paciente',
                'avatar'          => $user['avatar_url'] ?? null,
                'auth_type'       => 'google',
                'acudiente' => [
                    'nombre'   => $user['acudiente_nombre'] ?? null,
                    'cedula'   => $user['acudiente_cedula'] ?? null,
                    'relacion' => $user['acudiente_relacion'] ?? null,
                    'correo'   => $user['acudiente_correo'] ?? null,
                ],
            ];

            // ── Redirigir al inicio ────────────────────────────────
            $this->redirect('pages/index');

        } catch (\Throwable $e) {
            // Log del error (solo visible en el servidor, no al usuario)
            error_log('[GoogleOAuth] ' . $e->getMessage());
            $this->redirect('auth/error?reason=server_error');
        }
    }

    // ──────────────────────────────────────────────────────────────
    //  Página de error OAuth
    // ──────────────────────────────────────────────────────────────

    /**
     * GET /auth/error
     * Página amigable cuando algo falla en el flujo OAuth.
     */
    public function error(): void
    {
        $reason = htmlspecialchars($_GET['reason'] ?? 'unknown', ENT_QUOTES, 'UTF-8');
        $this->layout = 'tailwind';
        $this->render('auth/error', ['reason' => $reason]);
    }
}
