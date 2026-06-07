<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';

/**
 * Controlador para la vista de Panel de Psicólogas
 */
class ControllerPanel_psicologas extends Controller
{
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
    // POST /panel_psicologas/crearRecurso
    // Body JSON: { id_usuario, titulo, url_video, descripcion }
    // ────────────────────────────────────────────────────────────────
    public function crearRecurso(): void
    {
        header('Content-Type: application/json; charset=utf-8');
        $this->requirePsicologo(true);

        $body        = json_decode(file_get_contents('php://input'), true);
        $idUsuario   = (int)($body['id_usuario']  ?? 0);
        $titulo      = trim($body['titulo']        ?? '');
        $urlVideo    = trim($body['url_video']     ?? '');
        $descripcion = trim($body['descripcion']   ?? '');
        $idPsicologo = (int)$_SESSION['user']['id'];

        if ($idUsuario < 1 || !$titulo || !$urlVideo) {
            echo json_encode(['ok' => false, 'error' => 'Datos incompletos.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/RecursoModel.php';
        $model = new RecursoModel();
        $ok    = $model->createRecurso($idPsicologo, $idUsuario, $titulo, $urlVideo, $descripcion);

        echo json_encode($ok
            ? ['ok' => true,  'mensaje' => 'Recurso guardado.']
            : ['ok' => false, 'error'   => 'Error al guardar el recurso.']
        );
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
