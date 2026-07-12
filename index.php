<?php
/**
 * Punto de entrada único (Front Controller)
 * Toda petición HTTP pasa por aquí gracias al .htaccess
 */

define('BASE_PATH', __DIR__ . '/');

/**
 * Detección dinámica de URL_BASE
 * Funciona desde cualquier dispositivo/red/emulador (XAMPP, WAMP, Laragon, etc.)
 * sin necesidad de editar el código.
 */
(function () {
    // Protocolo: detectar si es HTTPS o HTTP
    $isHttps = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off')
        || (isset($_SERVER['HTTP_X_FORWARDED_PROTO']) && $_SERVER['HTTP_X_FORWARDED_PROTO'] === 'https')
        || ($_SERVER['SERVER_PORT'] ?? 80) == 443;
    $scheme = $isHttps ? 'https' : 'http';

    // Host (incluye el puerto si no es el estándar)
    $host = $_SERVER['HTTP_HOST'] ?? $_SERVER['SERVER_NAME'] ?? 'localhost';

    // Ruta base del proyecto (relativa a la raíz del servidor web)
    // __DIR__ = /ruta/al/proyecto, DOCUMENT_ROOT = /ruta/raiz/web
    $docRoot   = rtrim(str_replace('\\', '/', $_SERVER['DOCUMENT_ROOT'] ?? ''), '/');
    $scriptDir = rtrim(str_replace('\\', '/', __DIR__), '/');

    // La sub-ruta es la diferencia entre la carpeta del proyecto y el document root
    $subPath = '';
    if ($docRoot !== '' && strpos($scriptDir, $docRoot) === 0) {
        $subPath = substr($scriptDir, strlen($docRoot));
    }

    // Construir URL_BASE limpia con trailing slash
    define('URL_BASE', $scheme . '://' . $host . $subPath . '/');
})();

// Autoloader simple: carga clases desde app/
spl_autoload_register(function (string $class) {
    $paths = [
        BASE_PATH . 'core/',
        BASE_PATH . 'app/controllers/',
        BASE_PATH . 'app/models/',
        BASE_PATH . 'app/services/',
        BASE_PATH . 'app/dtos/',
    ];
    foreach ($paths as $path) {
        $file = $path . $class . '.php';
        if (file_exists($file)) {
            require_once $file;
            return;
        }
    }
});

// Cargar variables de entorno
require_once BASE_PATH . 'core/EnvLoader.php';
EnvLoader::load(BASE_PATH . '.env');

// Iniciar sesión globalmente
session_start();

// Arrancar el router
require_once __DIR__ . '/core/Router.php';
$router = new Router();
$router->dispatch();
