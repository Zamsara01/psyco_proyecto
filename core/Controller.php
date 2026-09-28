<?php
/**
 * Controlador base
 *
 * Provee render() para que los controladores hijos
 * puedan cargar vistas sin usar include_once directamente.
 * También inyecta variables en el scope de la vista.
 */
abstract class Controller
{
    /** @var string Nombre del layout a usar */
    protected string $layout = 'main';
    /**
     * Renderiza una vista dentro del layout principal.
     *
     * @param string $view   Ruta relativa desde app/views/  (ej. "products/list")
     * @param array  $data   Variables que estarán disponibles en la vista
     * @param bool   $layout Si false, renderiza sin layout (útil para fragmentos AJAX)
     */
    protected function render(string $view, array $data = [], bool $layout = true): void
    {
        // Extraer variables para que estén disponibles en la vista
        extract($data);

        $viewFile = dirname(__DIR__) . '/app/views/' . $view . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Vista no encontrada: {$viewFile}");
        }

        if ($layout) {
            // El layout espera que $content sea el HTML de la vista
            ob_start();
            require $viewFile;
            $content = ob_get_clean();

            require dirname(__DIR__) . '/app/views/layouts/' . $this->layout . '.php';
        } else {
            require $viewFile;
        }
    }

    /** Redirige a una URL relativa a URL_BASE */
    protected function redirect(string $path): void
    {
        header('Location: ' . URL_BASE . ltrim($path, '/'));
        exit;
    }

    /**
     * Guard centralizado de autenticación y autorización.
     *
     * Comportamiento:
     *   • Sin sesión activa → 401 JSON  o  redirect a users/login
     *   • Sesión con rol incorrecto → 403 JSON  o  redirect a pages/index
     *
     * @param string|null $rol   Rol requerido ('paciente', 'psicologo', 'administrador').
     *                           Si es null, solo verifica que haya sesión activa.
     * @param bool        $json  true → responde JSON y hace exit (endpoints API).
     *                           false → redirige con header Location (vistas HTML).
     */
    protected function requireAuth(?string $rol = null, bool $json = false): void
    {
        // ── 1. Sin sesión ────────────────────────────────────────────
        if (empty($_SESSION['user'])) {
            if ($json) {
                http_response_code(401);
                echo json_encode(['ok' => false, 'error' => 'No autorizado.']);
                exit;
            }
            $this->redirect('users/login');
        }

        // ── 2. Sesión activa pero rol equivocado ─────────────────────
        if ($rol !== null && ($_SESSION['user']['rol'] ?? '') !== $rol) {
            if ($json) {
                http_response_code(403);
                echo json_encode(['ok' => false, 'error' => 'Acceso denegado.']);
                exit;
            }
            http_response_code(403);
            $this->redirect('pages/index');
        }
    }
}
