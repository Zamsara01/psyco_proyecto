<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
/**
 * Controlador para la vista de Panel de Psicólogas
 */
class ControllerPanel_psicologas extends Controller
{
    public function index(): void
    {
        // Redirigir si no hay sesión o si no es psicóloga
        if (!isset($_SESSION['user']) || $_SESSION['user']['rol'] !== 'psicologo') {
            $this->redirect('users/login');
            return;
        }

        $idPsicologo = $_SESSION['user']['id'];

        require_once dirname(__DIR__) . '/models/CitaModel.php';
        $citaModel = new CitaModel();

        $stats = $citaModel->getDashboardStats($idPsicologo);
        $citasRecientes = $citaModel->getCitasRecientes($idPsicologo, 15);
        $citasHoy = $citaModel->getCitasHoy($idPsicologo);

        $this->layout = 'tailwind';
        $this->render('pages/panelpsicologas', [
            'stats' => $stats,
            'citasRecientes' => $citasRecientes,
            'citasHoy' => $citasHoy
        ]);
    }
}
