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

    public function presentacion(): void
    {
        $this->render('pages/presentacion');
    }

    public function presentacion2(): void
    {
        $this->render('pages/presentacion2');
    }

    public function presentacion3(): void { $this->render('pages/presentacion3'); }
    public function presentacion4(): void { $this->render('pages/presentacion4'); }
    public function presentacion5(): void { $this->render('pages/presentacion5'); }
    public function presentacion6(): void { $this->render('pages/presentacion6'); }
    public function presentacion7(): void { $this->render('pages/presentacion7'); }
    public function presentacion8(): void { $this->render('pages/presentacion8'); }
    public function presentacion9(): void { $this->render('pages/presentacion9'); }
    public function presentacion10(): void { $this->render('pages/presentacion10'); }
    public function presentacion11(): void { $this->render('pages/presentacion11'); }
    public function presentacion12(): void { $this->render('pages/presentacion12'); }

    public function about(): void
    {
        $this->render('pages/about');
    }

    public function services(): void
    {
        $this->render('pages/services');
    }

    public function catalog(): void
    {
        $this->render('pages/catalog');
    }
}
