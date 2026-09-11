<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';

/**
 * Controlador para la vista de Panel de Psicólogas
 */
class ControllerPanel_psicologas extends Controller
{
    // Ruta absoluta al directorio de uploads de recursos
    private const UPLOADS_DIR = __DIR__ . '/../../public/uploads/recursos/';

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas — Panel principal
    // ────────────────────────────────────────────────────────────────
    public function index(): void
    {
        $this->requirePsicologo();

        $idPsicologo = (int)$_SESSION['user']['id'];

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        require_once dirname(__DIR__) . '/models/NotaPacienteModel.php';

        $citaModel = new CitaModel();
        $notaModel = new NotaPacienteModel();

        $stats          = $citaModel->getDashboardStats($idPsicologo);
        $citasRecientes = $citaModel->getCitasRecientes($idPsicologo, 15);
        $citasHoy       = $citaModel->getCitasHoy($idPsicologo);
        $pacientesHoy   = $notaModel->getNotasParaPacientesDeHoy($idPsicologo);

        $this->layout = 'tailwind';
        $this->render('pages/panelpsicologas', [
            'stats'          => $stats,
            'citasRecientes' => $citasRecientes,
            'citasHoy'       => $citasHoy,
            'pacientesHoy'   => $pacientesHoy,
        ]);
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/notasPacientes — Vista completa de notas
    // ────────────────────────────────────────────────────────────────
    public function notasPacientes(): void
    {
        $this->requirePsicologo();

        $idPsicologo = (int)$_SESSION['user']['id'];

        require_once dirname(__DIR__) . '/models/NotaPacienteModel.php';
        $notaModel = new NotaPacienteModel();
        
        $pacientesHoy = $notaModel->getNotasParaPacientesDeHoy($idPsicologo);

        $this->layout = 'tailwind';
        $this->render('pages/notas_pacientes', [
            'pacientesHoy' => $pacientesHoy,
        ]);
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/buscarPaciente?q=...
    // ────────────────────────────────────────────────────────────────
    public function buscarPaciente(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $query       = trim($_GET['q'] ?? '');
        $idPsicologo = (int)$_SESSION['user']['id'];

        if (strlen($query) < 2) {
            echo json_encode(['ok' => false, 'error' => 'Escribe al menos 2 caracteres.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        $model    = new CitaModel();
        $pacientes = $model->buscarPacientes($query, $idPsicologo);

        echo json_encode(['ok' => true, 'pacientes' => $pacientes]);
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/historialPaciente?id_usuario=X
    // ────────────────────────────────────────────────────────────────
    public function historialPaciente(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $idUsuario   = (int)($_GET['id_usuario'] ?? 0);
        $idPsicologo = (int)$_SESSION['user']['id'];

        if ($idUsuario < 1) {
            echo json_encode(['ok' => false, 'error' => 'Usuario inválido.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        $model    = new CitaModel();
        $historial = $model->getHistorialPaciente($idUsuario, $idPsicologo);

        echo json_encode(['ok' => true, 'historial' => $historial]);
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/notasPaciente?id_usuario=X
    // API: devuelve notas personalizadas + notas de sesión
    // ────────────────────────────────────────────────────────────────
    public function notasPaciente(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $idUsuario   = (int)($_GET['id_usuario'] ?? 0);
        $idPsicologo = (int)$_SESSION['user']['id'];

        if ($idUsuario < 1) {
            echo json_encode(['ok' => false, 'error' => 'Usuario inválido.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/NotaPacienteModel.php';
        $model = new NotaPacienteModel();
        $notas = $model->getNotasByPsicologoAndUsuario($idPsicologo, $idUsuario);

        echo json_encode(['ok' => true, 'notas' => $notas]);
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // POST /panel_psicologas/crearNota
    // Body JSON: { id_usuario, titulo, contenido }
    // ────────────────────────────────────────────────────────────────
    public function crearNota(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $body        = json_decode(file_get_contents('php://input'), true);
        $idUsuario   = (int)($body['id_usuario'] ?? 0);
        $titulo      = trim($body['titulo']      ?? '');
        $contenido   = trim($body['contenido']   ?? '');
        $idPsicologo = (int)$_SESSION['user']['id'];

        if ($idUsuario < 1 || !$titulo || !$contenido) {
            echo json_encode(['ok' => false, 'error' => 'Datos incompletos.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/NotaPacienteModel.php';
        $model = new NotaPacienteModel();
        $ok    = $model->createNota($idPsicologo, $idUsuario, $titulo, $contenido);

        echo json_encode($ok
            ? ['ok' => true,  'mensaje' => 'Nota guardada.']
            : ['ok' => false, 'error'   => 'Error al guardar la nota.']
        );
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/recursos — Vista de gestión de recursos
    // ────────────────────────────────────────────────────────────────
    public function recursos(): void
    {
        $this->requirePsicologo();
        $idPsicologo = (int)$_SESSION['user']['id'];

        require_once dirname(__DIR__) . '/models/RecursoModel.php';
        require_once dirname(__DIR__) . '/models/UserModel.php';
        
        $model     = new RecursoModel();
        $recursos  = $model->getRecursosByPsicologo($idPsicologo);
        
        $userModel = new UserModel();
        $pacientes = $userModel->getActivePatientsWithDisorder();

        $this->layout = 'tailwind';
        $this->render('pages/recursos_psicologa', [
            'recursos'  => $recursos,
            'pacientes' => $pacientes,
        ]);
    }

    // ────────────────────────────────────────────────────────────────
    // POST /panel_psicologas/publicarRecurso (multipart/form-data)
    // Campos: tipo, titulo, descripcion, destino (especifico|todos),
    //         id_usuario?, url_video?, imagen (file)
    // ────────────────────────────────────────────────────────────────
    public function publicarRecurso(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $idPsicologo = (int)$_SESSION['user']['id'];
        $tipo        = trim($_POST['tipo']        ?? '');
        $titulo      = trim($_POST['titulo']      ?? '');
        $descripcion = trim($_POST['descripcion'] ?? '');
        $destino     = trim($_POST['destino']     ?? 'todos'); // 'especifico' | 'todos'
        
        $idUsuarios  = [];
        if ($destino === 'especifico') {
            if (isset($_POST['id_usuarios']) && is_array($_POST['id_usuarios'])) {
                $idUsuarios = array_map('intval', $_POST['id_usuarios']);
            } elseif (!empty($_POST['id_usuario'])) {
                $idUsuarios = [(int)$_POST['id_usuario']];
            }
        }

        $tiposValidos = ['video', 'mensaje', 'imagen'];
        if (!in_array($tipo, $tiposValidos, true) || !$titulo) {
            echo json_encode(['ok' => false, 'error' => 'Tipo y título son obligatorios.']);
            exit;
        }

        $urlVideo   = null;
        $imagenRuta = null;

        if ($tipo === 'video') {
            $urlVideo = trim($_POST['url_video'] ?? '');
            if (!$urlVideo) {
                echo json_encode(['ok' => false, 'error' => 'La URL del video es obligatoria.']);
                exit;
            }
        } elseif ($tipo === 'imagen') {
            // Verificar que llegó el archivo
            if (!isset($_FILES['imagen']) || $_FILES['imagen']['error'] === UPLOAD_ERR_NO_FILE) {
                echo json_encode(['ok' => false, 'error' => 'Debes seleccionar una imagen.']);
                exit;
            }

            $file = $_FILES['imagen'];

            // Decodificar código de error de PHP
            if ($file['error'] !== UPLOAD_ERR_OK) {
                $errMsgs = [
                    UPLOAD_ERR_INI_SIZE   => 'La imagen supera el límite del servidor (máx. permitido por configuración).',
                    UPLOAD_ERR_FORM_SIZE  => 'La imagen supera el límite del formulario.',
                    UPLOAD_ERR_PARTIAL    => 'La imagen se subió de forma parcial. Inténtalo de nuevo.',
                    UPLOAD_ERR_NO_TMP_DIR => 'Error del servidor: falta directorio temporal para subidas.',
                    UPLOAD_ERR_CANT_WRITE => 'Error del servidor: no se pudo escribir la imagen en el disco.',
                    UPLOAD_ERR_EXTENSION  => 'Una extensión de PHP bloqueó la subida del archivo.',
                ];
                $msg = $errMsgs[$file['error']] ?? "Error al subir la imagen (código PHP: {$file['error']}).";
                echo json_encode(['ok' => false, 'error' => $msg]);
                exit;
            }

            // Validar que sea un archivo subido legítimamente
            if (empty($file['tmp_name']) || !is_uploaded_file($file['tmp_name'])) {
                echo json_encode(['ok' => false, 'error' => 'El archivo de imagen no es válido.']);
                exit;
            }

            // Validar extensión
            $ext     = strtolower(pathinfo($file['name'], PATHINFO_EXTENSION));
            $allowed = ['jpg', 'jpeg', 'png', 'gif', 'webp'];
            if (!in_array($ext, $allowed, true)) {
                echo json_encode(['ok' => false, 'error' => 'Formato de imagen no permitido. Usa JPG, PNG, GIF o WebP.']);
                exit;
            }

            // Validar tamaño (5 MB)
            if ($file['size'] > 5 * 1024 * 1024) {
                echo json_encode(['ok' => false, 'error' => 'La imagen no puede superar 5 MB.']);
                exit;
            }

            // Validar MIME type real con finfo para mayor seguridad
            if (function_exists('finfo_open')) {
                $finfo    = finfo_open(FILEINFO_MIME_TYPE);
                $mimeReal = finfo_file($finfo, $file['tmp_name']);
                finfo_close($finfo);
                $mimesPermitidos = ['image/jpeg', 'image/png', 'image/gif', 'image/webp'];
                if (!in_array($mimeReal, $mimesPermitidos, true)) {
                    echo json_encode(['ok' => false, 'error' => 'El archivo no es una imagen válida.']);
                    exit;
                }
            }

            // Crear directorio si no existe
            if (!is_dir(self::UPLOADS_DIR)) {
                if (!mkdir(self::UPLOADS_DIR, 0775, true)) {
                    echo json_encode(['ok' => false, 'error' => 'No se pudo crear el directorio de subidas en el servidor.']);
                    exit;
                }
            }

            // Verificar permisos de escritura
            if (!is_writable(self::UPLOADS_DIR)) {
                echo json_encode(['ok' => false, 'error' => 'El directorio de imágenes no tiene permisos de escritura. Contacta al administrador.']);
                exit;
            }

            $nombre   = uniqid('img_', true) . '.' . $ext;
            $destPath = self::UPLOADS_DIR . $nombre;

            if (!move_uploaded_file($file['tmp_name'], $destPath)) {
                echo json_encode(['ok' => false, 'error' => 'Error al mover la imagen al servidor. Verifica los permisos del directorio de uploads.']);
                exit;
            }

            $imagenRuta = 'public/uploads/recursos/' . $nombre;
        }
        // tipo === 'mensaje' no requiere campos extra además de descripcion

        require_once dirname(__DIR__) . '/models/RecursoModel.php';
        $model = new RecursoModel();
        
        if ($destino === 'todos') {
            $ok = $model->createRecurso($idPsicologo, null, $titulo, $tipo, $urlVideo, $imagenRuta, $descripcion);
        } else {
            if (empty($idUsuarios)) {
                echo json_encode(['ok' => false, 'error' => 'Debes seleccionar al menos un paciente.']);
                exit;
            }
            $ok = true;
            foreach ($idUsuarios as $idU) {
                if (!$model->createRecurso($idPsicologo, $idU, $titulo, $tipo, $urlVideo, $imagenRuta, $descripcion)) {
                    $ok = false;
                }
            }
        }

        echo json_encode($ok
            ? ['ok' => true,  'mensaje' => 'Recurso publicado correctamente.']
            : ['ok' => false, 'error'   => 'Error al guardar el recurso en la base de datos.']
        );
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/obtenerRecursos — Lista JSON
    // ────────────────────────────────────────────────────────────────
    public function obtenerRecursos(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $idPsicologo = (int)$_SESSION['user']['id'];
        require_once dirname(__DIR__) . '/models/RecursoModel.php';
        $model    = new RecursoModel();
        $recursos = $model->getRecursosByPsicologo($idPsicologo);

        echo json_encode(['ok' => true, 'recursos' => $recursos]);
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // POST /panel_psicologas/eliminarRecurso
    // Body JSON: { id_recurso }
    // ────────────────────────────────────────────────────────────────
    public function eliminarRecurso(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $body        = json_decode(file_get_contents('php://input'), true);
        $idRecurso   = (int)($body['id_recurso'] ?? 0);
        $idPsicologo = (int)$_SESSION['user']['id'];

        if ($idRecurso < 1) {
            echo json_encode(['ok' => false, 'error' => 'ID de recurso inválido.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/RecursoModel.php';
        $model     = new RecursoModel();
        $imagenRuta = $model->deleteRecurso($idRecurso, $idPsicologo);

        if ($imagenRuta === false) {
            echo json_encode(['ok' => false, 'error' => 'No se encontró el recurso o no tienes permisos.']);
            exit;
        }

        // Eliminar archivo de imagen del disco si existe
        if ($imagenRuta) {
            $fullPath = dirname(__DIR__, 2) . '/' . $imagenRuta;
            if (file_exists($fullPath)) @unlink($fullPath);
        }

        echo json_encode(['ok' => true, 'mensaje' => 'Recurso eliminado correctamente.']);
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/buscarTodosLosPacientes?q=...
    // Busca cualquier usuario activo (no solo los del psicólogo)
    // ────────────────────────────────────────────────────────────────
    public function buscarTodosLosPacientes(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $query = trim($_GET['q'] ?? '');
        if (strlen($query) < 2) {
            echo json_encode(['ok' => false, 'error' => 'Escribe al menos 2 caracteres.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/UserModel.php';
        $model    = new UserModel();
        $pacientes = $model->buscarTodos($query);

        echo json_encode(['ok' => true, 'pacientes' => $pacientes]);
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/horasDisponiblesAgenda?fecha=
    // Retorna los slots libres del propio psicólogo en una fecha
    // ────────────────────────────────────────────────────────────────
    public function horasDisponiblesAgenda(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $fecha       = $_GET['fecha'] ?? '';
        $idPsicologo = (int)$_SESSION['user']['id'];

        if (!$fecha || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            echo json_encode(['ok' => false, 'error' => 'Fecha inválida.']);
            exit;
        }

        $dias    = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        $diaSem  = $dias[(int)date('w', strtotime($fecha))];

        require_once dirname(__DIR__) . '/models/PsicologoModel.php';
        $model = new PsicologoModel();
        $horas = $model->getHorasDisponibles($idPsicologo, $fecha, $diaSem);

        echo json_encode(['ok' => true, 'horas' => $horas]);
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // POST /panel_psicologas/agendarCita
    // Body JSON: { id_usuario, fecha, hora, motivo_consulta }
    // ────────────────────────────────────────────────────────────────
    public function agendarCita(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $body            = json_decode(file_get_contents('php://input'), true);
        $idUsuario       = (int)($body['id_usuario']       ?? 0);
        $fecha           = trim($body['fecha']              ?? '');
        $hora            = trim($body['hora']               ?? '');
        $motivoConsulta  = trim($body['motivo_consulta']    ?? '');
        $idPsicologo     = (int)$_SESSION['user']['id'];

        if ($idUsuario < 1 || !$fecha || !$hora) {
            echo json_encode(['ok' => false, 'error' => 'Faltan datos obligatorios (paciente, fecha, hora).']);
            exit;
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha) || $fecha < date('Y-m-d')) {
            echo json_encode(['ok' => false, 'error' => 'La fecha es inválida o está en el pasado.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        $model     = new CitaModel();
        $resultado = $model->insertCitaPorPsicologo([
            'id_usuario'      => $idUsuario,
            'id_psicologo'    => $idPsicologo,
            'fecha'           => $fecha,
            'hora'            => $hora,
            'motivo_consulta' => $motivoConsulta,
        ]);

        if ($resultado === true) {
            echo json_encode(['ok' => true, 'mensaje' => 'Cita agendada correctamente.']);
        } else {
            echo json_encode(['ok' => false, 'error' => $resultado]);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // POST /panel_psicologas/crearPaciente
    // Body JSON: { grado, nombre, correo_electronico, contrasena,
    //              acudiente_nombre, acudiente_cedula,
    //              acudiente_relacion, acudiente_correo }
    // ────────────────────────────────────────────────────────────────
    public function crearPaciente(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $body              = json_decode(file_get_contents('php://input'), true);
        $grado             = trim($body['grado']              ?? '');
        $nombre            = trim($body['nombre']             ?? '');
        $correo            = trim($body['correo_electronico'] ?? '');
        $contrasena        = trim($body['contrasena']         ?? '');
        $acudNombre        = trim($body['acudiente_nombre']   ?? '');
        $acudCedula        = trim($body['acudiente_cedula']   ?? '');
        $acudRelacion      = trim($body['acudiente_relacion'] ?? '');
        $acudCorreo        = trim($body['acudiente_correo']   ?? '');

        if (!$grado || !$nombre || !$correo || !$contrasena) {
            echo json_encode(['ok' => false, 'error' => 'Grado, nombre, correo y contraseña son obligatorios.']);
            exit;
        }
        if (!filter_var($correo, FILTER_VALIDATE_EMAIL)) {
            echo json_encode(['ok' => false, 'error' => 'El correo electrónico no es válido.']);
            exit;
        }
        if ($acudCedula !== '' && !ctype_digit($acudCedula)) {
            echo json_encode(['ok' => false, 'error' => 'La cédula del acudiente solo puede contener números.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/UserModel.php';
        $model = new UserModel();

        if ($model->emailExists($correo)) {
            echo json_encode(['ok' => false, 'error' => 'Ya existe un paciente con ese correo electrónico.']);
            exit;
        }

        $userId = $model->create(
            $grado,
            $nombre,
            $correo,
            $contrasena,
            'no',          // acepta_politica — el psicólogo gestiona el consentimiento presencialmente
            $acudNombre,
            $acudCedula,
            $acudRelacion,
            $acudCorreo
        );

        if ($userId) {
            echo json_encode(['ok' => true, 'mensaje' => "Paciente «{$nombre}» creado correctamente.", 'id_usuario' => $userId]);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Error al crear el paciente.']);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // GET /panel_psicologas/obtenerDisponibilidad
    // ────────────────────────────────────────────────────────────────
    public function obtenerDisponibilidad(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $idPsicologo = (int)$_SESSION['user']['id'];
        require_once dirname(__DIR__) . '/models/PsicologoModel.php';
        $model = new PsicologoModel();
        $dispo = $model->getDisponibilidad($idPsicologo);

        // Format times to HH:MM for cleaner UI display
        foreach ($dispo as &$d) {
            $d['hora_inicio'] = substr($d['hora_inicio'], 0, 5);
            $d['hora_fin']    = substr($d['hora_fin'], 0, 5);
        }

        echo json_encode(['ok' => true, 'disponibilidad' => $dispo]);
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // POST /panel_psicologas/agregarDisponibilidad
    // Body JSON: { dia_semana, hora_inicio, hora_fin }
    // ────────────────────────────────────────────────────────────────
    public function agregarDisponibilidad(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $body   = json_decode(file_get_contents('php://input'), true);
        $dia    = trim($body['dia_semana'] ?? '');
        $inicio = trim($body['hora_inicio'] ?? '');
        $fin    = trim($body['hora_fin'] ?? '');
        $idPsicologo = (int)$_SESSION['user']['id'];

        $diasValidos = ['Lunes','Martes','Miércoles','Jueves','Viernes','Sábado','Domingo'];
        if (!in_array($dia, $diasValidos) || !$inicio || !$fin) {
            echo json_encode(['ok' => false, 'error' => 'Datos incompletos o inválidos.']);
            exit;
        }

        // Basic hour/minutes validation (ensure time format HH:MM)
        if (!preg_match('/^\d{2}:\d{2}$/', $inicio) || !preg_match('/^\d{2}:\d{2}$/', $fin)) {
            // Check if it has seconds and strip them or validate
            $inicio = substr($inicio, 0, 5);
            $fin    = substr($fin, 0, 5);
        }

        if (strtotime($inicio) >= strtotime($fin)) {
            echo json_encode(['ok' => false, 'error' => 'La hora de inicio debe ser anterior a la hora de fin.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/PsicologoModel.php';
        $model = new PsicologoModel();
        $ok    = $model->addDisponibilidad($idPsicologo, $dia, $inicio . ':00', $fin . ':00');

        if ($ok) {
            echo json_encode(['ok' => true, 'mensaje' => 'Bloque de disponibilidad guardado correctamente.']);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Este bloque de disponibilidad ya existe o entra en conflicto.']);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // POST /panel_psicologas/eliminarDisponibilidad
    // Body JSON: { id_disponibilidad }
    // ────────────────────────────────────────────────────────────────
    public function eliminarDisponibilidad(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $body             = json_decode(file_get_contents('php://input'), true);
        $idDisponibilidad = (int)($body['id_disponibilidad'] ?? 0);
        $idPsicologo      = (int)$_SESSION['user']['id'];

        if ($idDisponibilidad < 1) {
            echo json_encode(['ok' => false, 'error' => 'Identificador de disponibilidad inválido.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/PsicologoModel.php';
        $model = new PsicologoModel();
        $ok    = $model->deleteDisponibilidad($idPsicologo, $idDisponibilidad);

        if ($ok) {
            echo json_encode(['ok' => true, 'mensaje' => 'Bloque de disponibilidad eliminado correctamente.']);
        } else {
            echo json_encode(['ok' => false, 'error' => 'No se pudo eliminar el bloque de disponibilidad.']);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // Utilidad: verificar sesión de psicóloga
    // ────────────────────────────────────────────────────────────────
    private function requirePsicologo(bool $jsonResponse = false): void

    {
        if (empty($_SESSION['user']) || ($_SESSION['user']['rol'] ?? '') !== 'psicologo') {
            if ($jsonResponse) {
                http_response_code(401);
                echo json_encode(['ok' => false, 'error' => 'No autorizado.']);
                exit;
            }
            $this->redirect('users/login');
            exit;
        }
    }
}
