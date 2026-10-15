<?php
/**
 * Punto de entrada único (Front Controller)
 * Toda petición HTTP pasa por aquí gracias al .htaccess
 */

ini_set('display_errors', '1');
ini_set('display_startup_errors', '1');
error_reporting(E_ALL);

set_exception_handler(function (\Throwable $e) {
    @file_put_contents(__DIR__ . '/debug_error.log', date('Y-m-d H:i:s') . " - " . $e->getMessage() . "\n" . $e->getTraceAsString() . "\n", FILE_APPEND);
    http_response_code(500);
    echo "<h1>Error en la aplicación:</h1>";
    echo "<pre style='background:#222;color:#f88;padding:15px;border-radius:8px;font-size:14px;'>" . htmlspecialchars($e->getMessage()) . "\n\n" . htmlspecialchars($e->getTraceAsString()) . "</pre>";
    exit;
});

register_shutdown_function(function () {
    $err = error_get_last();
    if ($err && in_array($err['type'], [E_ERROR, E_PARSE, E_CORE_ERROR, E_COMPILE_ERROR])) {
        @file_put_contents(__DIR__ . '/debug_error.log', date('Y-m-d H:i:s') . " - Fatal: " . $err['message'] . " in " . $err['file'] . ":" . $err['line'] . "\n", FILE_APPEND);
        echo "<h1>Fatal error:</h1>";
        echo "<pre style='background:#222;color:#f88;padding:15px;border-radius:8px;font-size:14px;'>" . htmlspecialchars($err['message']) . " in " . $err['file'] . ":" . $err['line'] . "</pre>";
    }
});

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
