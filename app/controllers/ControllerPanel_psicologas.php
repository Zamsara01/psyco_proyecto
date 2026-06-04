<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
/**
 * Controlador para la vista de Panel de Psicólogas
 */
class ControllerPanel_psicologas extends Controller
{
    public function index(): void
    {
        $this->layout = 'tailwind';
        $this->render('pages/panelpsicologas');
    }
}
