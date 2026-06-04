<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
/**
 * Controlador para la vista del Calendario
 */
class ControllerCalendario extends Controller
{
    public function index(): void
    {
        // Obtener psicólogos
        $psicologosJson = '[]';
        try {
            require_once dirname(__DIR__) . '/models/PsicologoModel.php';
            $model = new PsicologoModel();
            $data  = $model->getAllWithAvailability();
            $psicologosJson = json_encode($data, JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $psicologosJson = '[]';
        }

        // Obtener citas (ocupación)
        $citasJson = '{}';
        try {
            require_once dirname(__DIR__) . '/models/CitaModel.php';
            $citaModel = new CitaModel();
            $ocupacion = $citaModel->getOcupacionPorFecha();
            $citasJson = json_encode($ocupacion, JSON_UNESCAPED_UNICODE);
        } catch (\Exception $e) {
            $citasJson = '{}';
        }

        $this->layout = 'tailwind';
        $this->render('pages/calendario', [
            'psicologosJson' => $psicologosJson,
            'citasJson'      => $citasJson
        ]);
    }
}
