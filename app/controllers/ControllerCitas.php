<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';

/**
 * ControllerCitas
 * Gestiona las citas del paciente: listar, cancelar, editar.
 * También sirve las APIs JSON para el frontend.
 */
class ControllerCitas extends Controller
{
    // ────────────────────────────────────────────────────────────────
    // GET /citas/misCitas — Vista de citas del paciente
    // ────────────────────────────────────────────────────────────────
    public function misCitas(): void
    {
        $this->requireAuth('paciente'); // reemplaza chequeo inline duplicado

        $idPaciente = (int)$_SESSION['user']['id_paciente'];

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        require_once dirname(__DIR__) . '/models/PsicologoModel.php';

        $citaModel    = new CitaModel();
        $psicologoModel = new PsicologoModel();

        $citas      = $citaModel->getCitasUsuario($idPaciente);
        $psicologos = $psicologoModel->getAllActivos();

        $this->layout = 'tailwind';
        $this->render('pages/miscitas', [
            'citas'      => $citas,
            'psicologos' => $psicologos,
        ]);
    }

    // ────────────────────────────────────────────────────────────────
    // GET /citas/misRecursos — Vista de recursos del paciente
    // ────────────────────────────────────────────────────────────────
    public function misRecursos(): void
    {
        $this->requireAuth('paciente'); // reemplaza chequeo inline duplicado

        $idPaciente = (int)$_SESSION['user']['id_paciente'];

        require_once dirname(__DIR__) . '/models/RecursoModel.php';
        require_once dirname(__DIR__) . '/models/RecursoModel.php';

        $recursoModel = new RecursoModel();

        $recursos = $recursoModel->getRecursosByPaciente($idPaciente);

        $this->layout = 'tailwind';
        $this->render('pages/misrecursos', [
            'recursos' => $recursos,
        ]);
    }

    // ────────────────────────────────────────────────────────────────
    // API: POST /citas/cancelar  — Body JSON: { id_cita }
    // ────────────────────────────────────────────────────────────────
    public function cancelar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $this->requireAuth('paciente', true); // reemplaza chequeo inline duplicado

        $body      = json_decode(file_get_contents('php://input'), true);
        $idCita    = (int)($body['id_cita'] ?? 0);
        $idPaciente = (int)$_SESSION['user']['id_paciente'];

        if ($idCita < 1) {
            echo json_encode(['ok' => false, 'error' => 'Cita inválida.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        $model = new CitaModel();
        $ok    = $model->cancelarCita($idCita, $idPaciente);

        echo json_encode($ok
            ? ['ok' => true,  'mensaje' => 'Cita cancelada exitosamente.']
            : ['ok' => false, 'error'   => 'No se pudo cancelar la cita (ya puede estar cancelada o no te pertenece).']
        );
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // API: POST /citas/cancelarPsicologa
    // ────────────────────────────────────────────────────────────────
    public function cancelarPsicologa(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $this->requireAuth('psicologo', true); // reemplaza chequeo inline duplicado

        $body      = json_decode(file_get_contents('php://input'), true);
        $idCita    = (int)($body['id_cita'] ?? 0);
        $motivo    = trim($body['motivo'] ?? '');
        $idPsicologo = (int)$_SESSION['user']['id_paciente'];

        if ($idCita < 1 || empty($motivo)) {
            echo json_encode(['ok' => false, 'error' => 'Cita o motivo inválido.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        $citaModel = new CitaModel();

        $citaInfo = $citaModel->getCitaInfoParaCancelacion($idCita, $idPsicologo);
        if (!$citaInfo) {
            echo json_encode(['ok' => false, 'error' => 'No se pudo cancelar. La cita no existe o ya no está pendiente.']);
            exit;
        }

        $ok = $citaModel->cancelarCitaPsicologa($idCita, $idPsicologo);

        if ($ok) {
            require_once dirname(__DIR__) . '/models/RecursoModel.php';
            $recursoModel = new RecursoModel();
            
            $tituloMensaje = "Cancelación de Cita";
            
            $fechaF = date('d/m/Y', strtotime($citaInfo['fecha']));
            $horaF = substr($citaInfo['hora'], 0, 5);
            $contenidoMensaje = "La cita programada para el $fechaF a las $horaF ha sido cancelada.\n\nMotivo:\n$motivo";
            
            $recursoModel->createRecurso(
                $idPsicologo, 
                $citaInfo['id_paciente'], 
                $tituloMensaje, 
                'mensaje', 
                null, 
                null, 
                $contenidoMensaje
            );

            echo json_encode(['ok' => true, 'mensaje' => 'Cita cancelada exitosamente y paciente notificado.']);
        } else {
            echo json_encode(['ok' => false, 'error' => 'Error al cancelar la cita en la base de datos.']);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // API: POST /citas/editar
    // Body JSON: { id_cita, fecha, hora, id_psicologo }
    // ────────────────────────────────────────────────────────────────
    public function editar(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $this->requireAuth('paciente', true); // reemplaza chequeo inline duplicado

        $body          = json_decode(file_get_contents('php://input'), true);
        $idCita        = (int)($body['id_cita']      ?? 0);
        $nuevaFecha    = $body['fecha']               ?? '';
        $nuevaHora     = $body['hora']                ?? '';
        $nuevoIdPsico  = (int)($body['id_psicologo'] ?? 0);
        $idPaciente     = (int)$_SESSION['user']['id_paciente'];

        if ($idCita < 1 || !$nuevaFecha || !$nuevaHora || $nuevoIdPsico < 1) {
            echo json_encode(['ok' => false, 'error' => 'Datos incompletos.']);
            exit;
        }
        if (!preg_match('/^\d{4}-\d{2}-\d{2}$/', $nuevaFecha) || $nuevaFecha < date('Y-m-d')) {
            echo json_encode(['ok' => false, 'error' => 'Fecha inválida o en el pasado.']);
            exit;
        }
        if (!preg_match('/^\d{2}:\d{2}$/', $nuevaHora)) {
            echo json_encode(['ok' => false, 'error' => 'Hora inválida.']);
            exit;
        }

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        $model     = new CitaModel();
        $resultado = $model->editarCita($idCita, $idPaciente, $nuevaFecha, $nuevaHora, $nuevoIdPsico);

        if ($resultado === true) {
            echo json_encode(['ok' => true, 'mensaje' => 'Cita actualizada correctamente.']);
        } else {
            echo json_encode(['ok' => false, 'error' => $resultado]);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // API: GET /citas/horasDisponiblesEdicion?fecha=&id_psicologo=&id_cita=
    // ────────────────────────────────────────────────────────────────
    public function horasDisponiblesEdicion(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $fecha       = $_GET['fecha']         ?? '';
        $idPsicologo = (int)($_GET['id_psicologo'] ?? 0);

        if (!$fecha || $idPsicologo < 1) {
            echo json_encode(['ok' => false, 'error' => 'Parámetros inválidos.']);
            exit;
        }

        $dias   = ['Domingo','Lunes','Martes','Miércoles','Jueves','Viernes','Sábado'];
        $diaSem = $dias[(int)date('w', strtotime($fecha))];

        require_once dirname(__DIR__) . '/models/PsicologoModel.php';
        $model = new PsicologoModel();
        $horas = $model->getHorasDisponibles($idPsicologo, $fecha, $diaSem);

        echo json_encode(['ok' => true, 'horas' => $horas]);
        exit;
    }
}
