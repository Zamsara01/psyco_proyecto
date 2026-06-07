<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
require_once dirname(__DIR__) . '/models/UserModel.php';

/**
 * Controlador de usuarios — autenticación y gestión
 */
class ControllerUsers extends Controller
{
    private UserModel $userModel;

    public function __construct()
    {
        $this->userModel = new UserModel();
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
        
        // 1. Intentar login como Paciente (tabla usuarios)
        $user = $this->userModel->findByCredentials($email, $password);

        if ($user) {
            $_SESSION['user'] = [
                'id'              => $user['id_usuario'],
                'nombre'          => $user['nombre'],
                'correo'          => $user['correo_electronico'],
                'grado'           => $user['grado'],
                'estado'          => $user['estado'],
                'rol'             => 'paciente',
                'acudiente' => [
                    'nombre'   => $user['acudiente_nombre'] ?? null,
                    'cedula'   => $user['acudiente_cedula'] ?? null,
                    'relacion' => $user['acudiente_relacion'] ?? null,
                    'correo'   => $user['acudiente_correo'] ?? null,
                ],
            ];
            // Redirigir a inicio o calendario donde ahora tiene todo desbloqueado
            $this->redirect('pages/index');
            return;
        }

        // 2. Intentar login como Psicóloga (tabla psicologos)
        require_once dirname(__DIR__) . '/models/PsicologoModel.php';
        $psicoModel = new PsicologoModel();
        $psicologa = $psicoModel->findByCredentials($email, $password);

        if ($psicologa) {
            $_SESSION['user'] = [
                'id'     => $psicologa['id_psicologo'],
                'nombre' => $psicologa['nombre'],
                'correo' => $psicologa['correo_electronico'],
                'estado' => $psicologa['estado'],
                'rol'    => 'psicologo'
            ];
            // Redirigir a su panel de gestión
            $this->redirect('panel_psicologas/index');
            return;
        }

        // 3. Ambos fallaron
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

        if ($this->userModel->emailExists($email)) {
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
            $nombreAcudiente = trim($_POST['txtacudiente'] ?? '');
            $cedulaAcudiente = trim($_POST['txtcedula']    ?? '');
            $relacionAcudiente = $_POST['txtrelacion']       ?? '';
            $correoAcudiente = trim($_POST['txtcorreo_acudiente'] ?? '');
        }

        // ── Persistencia ─────────────────────────────────────────
        $userId = $this->userModel->create(
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
                session_start();
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
            session_start();
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
                $user = $this->userModel->findById((int)$userId);
                $_SESSION['user'] = [
                    'id'              => $user['id_usuario'],
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
            session_start();
        }

        $userId = $_SESSION['temp_user_id'] ?? null;
        $email  = $_SESSION['temp_user_email'] ?? '';

        if ($userId && $email) {
            require_once dirname(__DIR__) . '/models/OtpModel.php';
            require_once dirname(__DIR__, 2) . '/core/MailService.php';

            $user = $this->userModel->findById((int)$userId);

            $otpModel = new OtpModel();
            $codigoOtp = $otpModel->generateOtp($email, 'register');

            $mailService = new MailService();
            $mailService->sendOtpEmail($email, $user['nombre'], $codigoOtp);

            $_SESSION['otp_success'] = 'Se ha enviado un nuevo código a tu correo.';
        }

        $this->redirect('users/register');
    }

    /** GET /users/list */
    public function list(): void
    {
        $users = $this->userModel->getAll();
        $this->render('users/list', ['users' => $users]);
    }

    /** GET /users/edit/{id} */
    public function edit(): void
    {
        $id   = (int) ($_GET['id'] ?? 0);
        $user = $this->userModel->findById($id);
        $this->render('users/edit', ['user' => $user]);
    }

    /** GET /users/logout */
    public function logout(): void
    {
        session_destroy();
        $this->redirect('users/login');
    }
}
