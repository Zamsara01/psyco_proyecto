<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';

/**
 * Controlador para la vista del Chat Bot
 * También sirve como mini-API JSON para el flujo de agendamiento.
 */
class ControllerChat_bot extends Controller
{
    public function index(): void
    {
        $this->layout = 'tailwind';
        $this->render('pages/chatbot');
    }

    // ────────────────────────────────────────────────────────────────
    // API: GET  /chat_bot/psicologosDisponibles?fecha=YYYY-MM-DD
    // Devuelve psicólogos que tienen disponibilidad ese día de semana
    // ────────────────────────────────────────────────────────────────
    public function psicologosDisponibles(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $fecha = $_GET['fecha'] ?? '';
        if (!$fecha || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            echo json_encode(['ok' => false, 'error' => 'Fecha inválida']);
            exit;
        }

        // Pasar fecha a nombre del día en español
        $diaSemana = $this->diaSemanaEspanol($fecha);

        try {
            require_once dirname(__DIR__) . '/models/PsicologoModel.php';
            $model = new PsicologoModel();
            $psicologos = $model->getPsicologosDisponiblesPorDia($diaSemana);
            echo json_encode(['ok' => true, 'dia' => $diaSemana, 'psicologos' => $psicologos]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // API: GET  /chat_bot/horasDisponibles?fecha=YYYY-MM-DD&id_psicologo=X
    // Devuelve los slots libres (cada hora) para ese psicólogo en esa fecha
    // ────────────────────────────────────────────────────────────────
    public function horasDisponibles(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        $fecha       = $_GET['fecha']         ?? '';
        $idPsicologo = (int)($_GET['id_psicologo'] ?? 0);

        if (!$fecha || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha) || $idPsicologo < 1) {
            echo json_encode(['ok' => false, 'error' => 'Parámetros inválidos']);
            exit;
        }

        $diaSemana = $this->diaSemanaEspanol($fecha);

        try {
            require_once dirname(__DIR__) . '/models/PsicologoModel.php';
            $model = new PsicologoModel();
            $horas = $model->getHorasDisponibles($idPsicologo, $fecha, $diaSemana);
            echo json_encode(['ok' => true, 'horas' => $horas]);
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // API: POST /chat_bot/guardarCita
    // Body JSON: { fecha, id_psicologo, hora, motivo_consulta }
    // ────────────────────────────────────────────────────────────────
    public function guardarCita(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        // Verificar sesión
        if (empty($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'Debes iniciar sesión para agendar una cita.']);
            exit;
        }

        $body = json_decode(file_get_contents('php://input'), true);

        $fecha       = $body['fecha']            ?? '';
        $idPsicologo = (int)($body['id_psicologo'] ?? 0);
        $hora        = $body['hora']              ?? '';
        $motivo      = trim($body['motivo_consulta'] ?? '');

        // Validaciones básicas
        if (!$fecha || !preg_match('/^\d{4}-\d{2}-\d{2}$/', $fecha)) {
            echo json_encode(['ok' => false, 'error' => 'Fecha inválida.']);
            exit;
        }
        if ($idPsicologo < 1) {
            echo json_encode(['ok' => false, 'error' => 'Psicólogo inválido.']);
            exit;
        }
        if (!preg_match('/^\d{2}:\d{2}$/', $hora)) {
            echo json_encode(['ok' => false, 'error' => 'Hora inválida.']);
            exit;
        }
        if ($fecha < date('Y-m-d')) {
            echo json_encode(['ok' => false, 'error' => 'No puedes agendar en fechas pasadas.']);
            exit;
        }

        $idUsuario = (int)($_SESSION['user']['id'] ?? 0);
        if ($idUsuario < 1) {
            echo json_encode(['ok' => false, 'error' => 'Sesión inválida.']);
            exit;
        }

        try {
            require_once dirname(__DIR__) . '/models/CitaModel.php';
            $model = new CitaModel();
            $ok = $model->insertCita([
                'id_usuario'      => $idUsuario,
                'id_psicologo'    => $idPsicologo,
                'fecha'           => $fecha,
                'hora'            => $hora . ':00',
                'motivo_consulta' => $motivo ?: 'Sin motivo especificado',
                'notas_sesion'    => '',
            ]);

            if ($ok) {
                echo json_encode(['ok' => true, 'mensaje' => '¡Cita agendada con éxito!']);
            } else {
                echo json_encode(['ok' => false, 'error' => 'No se pudo guardar la cita.']);
            }
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }
    // ────────────────────────────────────────────────────────────────
    // API: POST /chat_bot/terminarCita
    // Body JSON: { id_cita, duracion_minutos, notas_sesion }
    // ────────────────────────────────────────────────────────────────
    public function terminarCita(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        if (empty($_SESSION['user'])) {
            http_response_code(401);
            echo json_encode(['ok' => false, 'error' => 'No autorizado.']);
            exit;
        }

        $body = json_decode(file_get_contents('php://input'), true);

        $idCita  = (int)($body['id_cita'] ?? 0);
        $duracion = (int)($body['duracion_minutos'] ?? 0);
        $notas   = trim($body['notas_sesion'] ?? '');

        if ($idCita < 1 || $duracion < 1) {
            echo json_encode(['ok' => false, 'error' => 'Datos inválidos.']);
            exit;
        }

        try {
            require_once dirname(__DIR__) . '/models/CitaModel.php';
            $model = new CitaModel();
            $ok = $model->terminarCita($idCita, $duracion, $notas);

            if ($ok) {
                echo json_encode(['ok' => true, 'mensaje' => 'Cita terminada exitosamente.']);
            } else {
                echo json_encode(['ok' => false, 'error' => 'No se pudo terminar la cita o no estaba en proceso.']);
            }
        } catch (\Exception $e) {
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        }
        exit;
    }

    // ────────────────────────────────────────────────────────────────
    // Utilidad: convierte YYYY-MM-DD al nombre del día en español
    // ────────────────────────────────────────────────────────────────
    private function diaSemanaEspanol(string $fecha): string
    {
        $dias = ['Domingo', 'Lunes', 'Martes', 'Miércoles', 'Jueves', 'Viernes', 'Sábado'];
        $ts   = strtotime($fecha);
        return $dias[(int)date('w', $ts)];
    }
}
