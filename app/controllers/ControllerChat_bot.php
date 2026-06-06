<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
/**
 * Controlador para la vista del Chat Bot
 */
class ControllerChat_bot extends Controller
{
    public function index(): void
    {
        $this->layout = 'tailwind';
        $this->render('pages/chatbot');
    }
}
