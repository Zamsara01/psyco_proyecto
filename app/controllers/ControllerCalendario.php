<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
/**
 * Controlador para la vista del Calendario
 */
class ControllerCalendario extends Controller
{
    public function index(): void
    {
        $this->layout = 'tailwind';
        $this->render('pages/calendario');
    }
}
