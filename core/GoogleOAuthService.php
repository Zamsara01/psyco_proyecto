<?php
/**
 * GoogleOAuthService
 *
 * Gestiona el flujo OAuth 2.0 de Google (Authorization Code Flow)
 * sin librerías externas: solo cURL y las variables del .env.
 *
 * Variables requeridas en .env:
 *   GOOGLE_CLIENT_ID
 *   GOOGLE_CLIENT_SECRET
 *   GOOGLE_REDIRECT_URI
 */
class GoogleOAuthService
{
    // ── Endpoints de Google ────────────────────────────────────────
    private const AUTH_URL  = 'https://accounts.google.com/o/oauth2/v2/auth';
    private const TOKEN_URL = 'https://oauth2.googleapis.com/token';
    private const USER_URL  = 'https://www.googleapis.com/oauth2/v3/userinfo';

    private string $clientId;
    private string $clientSecret;
    private string $redirectUri;

    public function __construct()
    {
        $this->clientId     = $_ENV['GOOGLE_CLIENT_ID']     ?? '';
        $this->clientSecret = $_ENV['GOOGLE_CLIENT_SECRET'] ?? '';
        $this->redirectUri  = $_ENV['GOOGLE_REDIRECT_URI']  ?? '';

        if (!$this->clientId || !$this->clientSecret || !$this->redirectUri) {
            throw new \RuntimeException(
                'GoogleOAuthService: faltan variables GOOGLE_CLIENT_ID, ' .
                'GOOGLE_CLIENT_SECRET o GOOGLE_REDIRECT_URI en el .env'
            );
        }
    }

    // ──────────────────────────────────────────────────────────────
    //  PASO 1 — URL de autorización
    // ──────────────────────────────────────────────────────────────

    /**
     * Genera la URL de Google a la que se redirige al usuario.
     * También guarda un token CSRF (state) en la sesión.
     */
    public function getAuthUrl(): string
    {
        $state = bin2hex(random_bytes(16));
        $_SESSION['oauth_state'] = $state;

        $params = http_build_query([
            'client_id'             => $this->clientId,
            'redirect_uri'          => $this->redirectUri,
            'response_type'         => 'code',
            'scope'                 => 'openid email profile',
            'access_type'           => 'online',
            'state'                 => $state,
            'prompt'                => 'select_account',
        ]);

        return self::AUTH_URL . '?' . $params;
    }

    // ──────────────────────────────────────────────────────────────
    //  PASO 2 — Intercambio de código por tokens
    // ──────────────────────────────────────────────────────────────

    /**
     * Intercambia el authorization_code recibido en el callback
     * por un access_token.
     *
     * @throws \RuntimeException si Google devuelve un error
     */
    public function exchangeCode(string $code): string
    {
        $response = $this->post(self::TOKEN_URL, [
            'code'          => $code,
            'client_id'     => $this->clientId,
            'client_secret' => $this->clientSecret,
            'redirect_uri'  => $this->redirectUri,
            'grant_type'    => 'authorization_code',
        ]);

        if (isset($response['error'])) {
            throw new \RuntimeException(
                'GoogleOAuth token error: ' . ($response['error_description'] ?? $response['error'])
            );
        }

        return $response['access_token'];
    }

    // ──────────────────────────────────────────────────────────────
    //  PASO 3 — Obtener datos del usuario
    // ──────────────────────────────────────────────────────────────

    /**
     * Devuelve el perfil del usuario de Google.
     *
     * @return array{sub:string, email:string, name:string, picture:string, email_verified:bool}
     * @throws \RuntimeException si la petición falla
     */
    public function getUserInfo(string $accessToken): array
    {
        $ch = curl_init(self::USER_URL);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_HTTPHEADER     => [
                'Authorization: Bearer ' . $accessToken,
                'Accept: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 10,
        ]);

        $body = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        $curlError = curl_error($ch);
        curl_close($ch);

        if ($curlError) {
            throw new \RuntimeException('GoogleOAuth cURL error: ' . $curlError);
        }

        $data = json_decode($body, true);

        if ($httpCode !== 200 || !isset($data['email'])) {
            throw new \RuntimeException(
                'GoogleOAuth userinfo error (HTTP ' . $httpCode . '): ' . $body
            );
        }

        return $data;
    }

    // ──────────────────────────────────────────────────────────────
    //  Validación CSRF
    // ──────────────────────────────────────────────────────────────

    /**
     * Verifica que el parámetro 'state' del callback coincida
     * con el guardado en sesión (protección CSRF).
     *
     * @throws \RuntimeException si no coinciden
     */
    public function validateState(string $receivedState): void
    {
        $expected = $_SESSION['oauth_state'] ?? '';
        unset($_SESSION['oauth_state']); // Usar solo una vez

        if (!hash_equals($expected, $receivedState)) {
            throw new \RuntimeException('GoogleOAuth: state inválido — posible ataque CSRF.');
        }
    }

    // ──────────────────────────────────────────────────────────────
    //  Helper privado — POST con cURL
    // ──────────────────────────────────────────────────────────────

    private function post(string $url, array $fields): array
    {
        $ch = curl_init($url);
        curl_setopt_array($ch, [
            CURLOPT_RETURNTRANSFER => true,
            CURLOPT_POST           => true,
            CURLOPT_POSTFIELDS     => http_build_query($fields),
            CURLOPT_HTTPHEADER     => [
                'Content-Type: application/x-www-form-urlencoded',
                'Accept: application/json',
            ],
            CURLOPT_SSL_VERIFYPEER => true,
            CURLOPT_TIMEOUT        => 15,
        ]);

        $body     = curl_exec($ch);
        $curlErr  = curl_error($ch);
        curl_close($ch);

        if ($curlErr) {
            throw new \RuntimeException('GoogleOAuth cURL POST error: ' . $curlErr);
        }

        return json_decode($body, true) ?? [];
    }
}
