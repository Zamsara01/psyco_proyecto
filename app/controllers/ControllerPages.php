<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';
/**
 * Controlador de páginas estáticas / informativas
 */
class ControllerPages extends Controller
{
    protected string $layout = 'tailwind'; // ← agregar esta línea
    
    public function index(): void
    {
        $this->render('pages/home');
    }

    public function terminos(): void
    {
        $this->render('pages/terminos');
    }



}
