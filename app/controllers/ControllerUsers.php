<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';

/**
 * Controlador de usuarios — autenticación y gestión
 */
class ControllerUsers extends Controller
{
    private ?UserModel $userModel = null;

    /** Lazy-load: solo conecta a la BD cuando se necesita, no en logout */
    private function getUserModel(): UserModel
    {
        if ($this->userModel === null) {
            require_once dirname(__DIR__) . '/models/UserModel.php';
            $this->userModel = new UserModel();
        }
        return $this->userModel;
    }

    public function login(): void
    {
        $error = '';
        if (isset($_GET['error']) && $_GET['error'] === 'not_registered_google') {
            $error = 'not_registered_google';
        }
        $this->layout = 'tailwind';
        $this->render('users/login', ['error' => $error]);
    }

        public function authenticate(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('users/login');
        }

        $email    = trim($_POST['txtEmail']    ?? '');
        $password = $_POST['txtPassword'] ?? '';
        
        $user = $this->getUserModel()->findByCredentials($email, $password);

        if ($user) {
            $rol = $user['rol'];
                        if ($rol === 'paciente') {
                $pacienteInfo = $this->getUserModel()->findById((int)$user['id_usuario']);
                $_SESSION['user'] = [
                    'id'              => $user['id_usuario'],
                    'id_paciente'     => $pacienteInfo['id_paciente'] ?? null,
                    'nombre'          => $user['nombre'],
                    'correo'          => $user['correo_electronico'],
                    'grado'           => $pacienteInfo['grado'] ?? null,
                    'estado'          => $user['estado'],
                    'rol'             => 'paciente',
                    'acudiente' => [
                        'nombre'   => $pacienteInfo['acudiente_nombre'] ?? null,
                        'cedula'   => $pacienteInfo['acudiente_cedula'] ?? null,
                        'relacion' => $pacienteInfo['acudiente_relacion'] ?? null,
                        'correo'   => $pacienteInfo['acudiente_correo'] ?? null,
                    ],
                ];
                $this->redirect('pages/index');
                return;
            } elseif ($rol === 'psicologo') {
                require_once dirname(__DIR__) . '/models/PsicologoModel.php';
                $psicoModel = new PsicologoModel();
                $psicologa = $psicoModel->findByCredentials($email, $password);
                if ($psicologa) {
                    $_SESSION['user'] = [
                        'id'     => $psicologa['id_psicologo'],
                        'id_usuario' => $user['id_usuario'],
                        'nombre' => $user['nombre'],
                        'correo' => $user['correo_electronico'],
                        'estado' => $user['estado'],
                        'rol'    => 'psicologo'
                    ];
                    $this->redirect('panel_psicologas/index');
                    return;
                }
            } elseif ($rol === 'superusuario') {
                require_once dirname(__DIR__) . '/models/SuperusuarioModel.php';
                $superModel = new SuperusuarioModel();
                $superusuario = $superModel->findByCredentials($email, $password);
                if ($superusuario) {
                    $_SESSION['user'] = [
                        'id'     => $superusuario['id_superusuario'],
                        'id_usuario' => $user['id_usuario'],
                        'nombre' => $user['nombre'],
                        'correo' => $user['correo_electronico'],
                        'estado' => $user['estado'],
                        'rol'    => 'superusuario'
                    ];
                    $this->redirect('superusuario/index');
                    return;
                }
            }
        }

        $this->layout = 'tailwind';
        $this->render('users/login', ['error' => 'Correo o contraseña inválidos']);
    }

    /** GET  /users/register — muestra formulario */
    public function register(): void
    {
        $this->layout = 'tailwind';
        $this->render('users/register');
    }

    /** POST /users/store — guarda nuevo usuario */
    public function store(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('users/register');
            return;
        }

        // ── Datos básicos ─────────────────────────────────────────
        $grado     = $_POST['txtgrado']    ?? '';
        $nombre    = trim($_POST['txtnombre']  ?? '');
        $email     = trim($_POST['txtEmail']   ?? '');
        $password  = $_POST['txtPassword']  ?? '';
        $password2 = $_POST['txtPassword2'] ?? '';

        // ── Validaciones básicas ──────────────────────────────────
        if (!$grado || !$nombre || !$email || !$password) {
            $this->layout = 'tailwind';
            $this->render('users/register', ['error' => 'Todos los campos obligatorios deben completarse.']);
            return;
        }

        if ($password !== $password2) {
            $this->layout = 'tailwind';
            $this->render('users/register', ['error' => 'Las contraseñas no coinciden.']);
            return;
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->layout = 'tailwind';
            $this->render('users/register', ['error' => 'El correo electrónico no es válido.']);
            return;
        }

        if ($this->getUserModel()->emailExists($email)) {
            $this->layout = 'tailwind';
            $this->render('users/register', ['error' => 'Este correo ya está registrado.']);
            return;
        }

        // ── Política de datos clínicos ────────────────────────────
        $aceptaPolitica = $_POST['acepta_politica'] ?? 'no';
        $nombreAcudiente = '';
        $cedulaAcudiente = '';
        $relacionAcudiente = '';
        $correoAcudiente = '';

        if ($aceptaPolitica === 'si') {
            $nombreAcudiente   = trim($_POST['txtacudiente'] ?? '');
            $cedulaAcudiente   = trim($_POST['txtcedula']    ?? '');
            $relacionAcudiente = $_POST['txtrelacion']       ?? '';
            $correoAcudiente   = trim($_POST['txtcorreo_acudiente'] ?? '');

            // ── Validar que la cédula sea solo numérica ─────────────
            if ($cedulaAcudiente !== '' && !ctype_digit($cedulaAcudiente)) {
                $this->layout = 'tailwind';
                $this->render('users/register', [
                    'error' => '❌ La cédula del acudiente solo puede contener números. Por favor, corrígela e intenta de nuevo.'
                ]);
                return;
            }
        }

        // ── Persistencia ─────────────────────────────────────────
        $userId = $this->getUserModel()->create(
            $grado,
            $nombre,
            $email,
            $password,
            $aceptaPolitica,
            $nombreAcudiente,
            $cedulaAcudiente,
            $relacionAcudiente,
            $correoAcudiente
        );

        if ($userId) {
            require_once dirname(__DIR__) . '/models/OtpModel.php';
            require_once dirname(__DIR__, 2) . '/core/MailService.php';

            $otpModel = new OtpModel();
            $codigoOtp = $otpModel->generateOtp($email, 'register');

            $mailService = new MailService();
            $mailService->sendOtpEmail($email, $nombre, $codigoOtp);

            if (session_status() === PHP_SESSION_NONE) {

            }

            // Guardamos temporalmente el ID y correo para la verificación OTP (abre el modal)
            $_SESSION['temp_user_id'] = $userId;
            $_SESSION['temp_user_email'] = $email;

            $this->redirect('users/register');
            return;
        }

        $this->layout = 'tailwind';
        $this->render('users/register', ['error' => 'Error al crear la cuenta.']);
    }

    /** GET|POST /users/verifyOtp — verifica el código */
    public function verifyOtp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {

        }

        $userId = $_SESSION['temp_user_id'] ?? null;
        $email  = $_SESSION['temp_user_email'] ?? '';

        if (!$userId || !$email) {
            $this->redirect('users/login');
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $codigo = trim($_POST['codigo'] ?? '');

            require_once dirname(__DIR__) . '/models/OtpModel.php';
            $otpModel = new OtpModel();
            $resultado = $otpModel->verifyOtp($email, $codigo, 'register');

            if ($resultado['status']) {
                // Eliminar sesión temporal
                unset($_SESSION['temp_user_id']);
                unset($_SESSION['temp_user_email']);

                                // Autenticar al usuario
                $user = $this->getUserModel()->findById((int)$userId);
                $_SESSION['user'] = [
                    'id'              => $user['id_usuario'],
                    'id_paciente'     => $user['id_paciente'] ?? null,
                    'nombre'          => $user['nombre'],
                    'correo'          => $user['correo_electronico'],
                    'grado'           => $user['grado'] ?? null,
                    'estado'          => $user['estado'],
                    'rol'             => 'paciente',
                    'acudiente' => [
                        'nombre'   => $user['acudiente_nombre'] ?? null,
                        'cedula'   => $user['acudiente_cedula'] ?? null,
                        'relacion' => $user['acudiente_relacion'] ?? null,
                        'correo'   => $user['acudiente_correo'] ?? null,
                    ],
                ];

                $this->redirect('pages/index');
                return;
            } else {
                $_SESSION['otp_error'] = $resultado['message'];
                $this->redirect('users/register');
                return;
            }
        }

        // Si entran por GET y hay temp_user_id, redirigir a registro para forzar el modal.
        $this->redirect('users/register');
    }

    /** POST /users/resendOtp — reenvía el código */
    public function resendOtp(): void
    {
        if (session_status() === PHP_SESSION_NONE) {

        }

        $userId = $_SESSION['temp_user_id'] ?? null;
        $email  = $_SESSION['temp_user_email'] ?? '';

        if ($userId && $email) {
            require_once dirname(__DIR__) . '/models/OtpModel.php';
            require_once dirname(__DIR__, 2) . '/core/MailService.php';

            $user = $this->getUserModel()->findById((int)$userId);

            $otpModel = new OtpModel();
            $codigoOtp = $otpModel->generateOtp($email, 'register');

            $mailService = new MailService();
            $mailService->sendOtpEmail($email, $user['nombre'], $codigoOtp);

            $_SESSION['otp_success'] = 'Se ha enviado un nuevo código a tu correo.';
        }

        $this->redirect('users/register');
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Alias de compatibilidad → delega al guard centralizado en Controller.
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * Exige rol 'administrador'.
     * Sin sesión → users/login.  Rol incorrecto → 403 + pages/index.
     * La lógica real vive en Controller::requireAuth().
     */
    private function requireAdmin(): void
    {
        $this->requireAuth('administrador'); // delega al guard centralizado
    }

    /** GET /users/list — solo administradores */
    public function list(): void
    {
        $this->requireAdmin();

        $users = $this->getUserModel()->getAll();
        $this->render('users/list', ['users' => $users]);
    }

    /** GET /users/edit?id=X — solo administradores */
    public function edit(): void
    {
        $this->requireAdmin();

        $id   = (int) ($_GET['id'] ?? 0);
        $user = $this->getUserModel()->findById($id);
        $this->render('users/edit', ['user' => $user]);
    }

    /** GET /users/logout */
    public function logout(): void
    {
        $_SESSION = [];

        if (ini_get('session.use_cookies')) {
            $params = session_get_cookie_params();
            setcookie(
                session_name(), '', time() - 42000,
                $params['path'], $params['domain'],
                $params['secure'], $params['httponly']
            );
        }

        if (session_status() === PHP_SESSION_ACTIVE) {
            session_destroy();
        }

        $this->redirect('users/login');
    }
}
