<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
require_once dirname(__DIR__, 2) . '/core/GoogleOAuthService.php';

/**
 * ControllerAuth
 *
 * Gestiona el flujo OAuth 2.0 con Google.
 */
class ControllerAuth extends Controller
{
    private ?GoogleOAuthService $oauthService = null;
    private ?UserModel $userModel = null;

    private function getOAuthService(): GoogleOAuthService
    {
        if ($this->oauthService === null) {
            $this->oauthService = new GoogleOAuthService();
        }
        return $this->oauthService;
    }

    private function getUserModel(): UserModel
    {
        if ($this->userModel === null) {
            require_once dirname(__DIR__) . '/models/UserModel.php';
            $this->userModel = new UserModel();
        }
        return $this->userModel;
    }

    public function google(): void
    {
        $authUrl = $this->getOAuthService()->getAuthUrl();
        header('Location: ' . $authUrl);
        exit;
    }

    public function googleCallback(): void
    {
        if (isset($_GET['error'])) {
            $this->redirect('auth/error?reason=' . urlencode($_GET['error']));
            return;
        }

        $code  = $_GET['code']  ?? '';
        $state = $_GET['state'] ?? '';

        if (!$code || !$state) {
            $this->redirect('auth/error?reason=missing_params');
            return;
        }

        try {
            $this->getOAuthService()->validateState($state);
            $accessToken = $this->getOAuthService()->exchangeCode($code);
            $googleUser = $this->getOAuthService()->getUserInfo($accessToken);

            $user = $this->getUserModel()->findByGoogle($googleUser);

            if (!$user) {
                $this->redirect('users/login?error=not_registered_google');
                return;
            }

            $pacienteInfo = $this->getUserModel()->findById((int)$user['id_usuario']);
            $_SESSION['user'] = [
                'id'              => $user['id_usuario'],
                'id_paciente'     => $pacienteInfo['id_paciente'] ?? null,
                'nombre'          => $user['nombre'],
                'correo'          => $user['correo_electronico'],
                'grado'           => $pacienteInfo['grado'] ?? null,
                'estado'          => $user['estado'],
                'rol'             => 'paciente',
                'avatar'          => $user['avatar_url'] ?? null,
                'auth_type'       => 'google',
                'acudiente' => [
                    'nombre'   => $pacienteInfo['acudiente_nombre'] ?? null,
                    'cedula'   => $pacienteInfo['acudiente_cedula'] ?? null,
                    'relacion' => $pacienteInfo['acudiente_relacion'] ?? null,
                    'correo'   => $pacienteInfo['acudiente_correo'] ?? null,
                ],
            ];

            $this->redirect('pages/index');

        } catch (\Throwable $e) {
            error_log('[GoogleOAuth] ' . $e->getMessage());
            $this->redirect('auth/error?reason=server_error');
        }
    }

    public function error(): void
    {
        $reason = htmlspecialchars($_GET['reason'] ?? 'unknown', ENT_QUOTES, 'UTF-8');
        $this->layout = 'tailwind';
        $this->render('auth/error', ['reason' => $reason]);
    }
}
