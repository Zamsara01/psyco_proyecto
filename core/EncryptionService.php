<?php
/**
 * EncryptionService
 * Servicio de cifrado autenticado usando AES-256-GCM.
 * Garantiza confidencialidad e integridad de los datos.
 */
class EncryptionService
{
    private const CIPHER = 'aes-256-gcm';
    private const VERSION = 'v1';

    /**
     * Obtiene y decodifica la clave maestra desde las variables de entorno.
     */
    private static function getKey(): string
    {
        $keyBase64 = getenv('ENCRYPTION_KEY');
        if (!$keyBase64) {
            throw new \RuntimeException('ENCRYPTION_KEY no está configurada en el entorno.');
        }

        $key = base64_decode($keyBase64);
        if (strlen($key) !== 32) {
            throw new \RuntimeException('ENCRYPTION_KEY debe ser de 256 bits (32 bytes) decodificada.');
        }

        return $key;
    }

    /**
     * Cifra un texto y retorna el formato: version:base64(iv):base64(tag):base64(ciphertext)
     * 
     * @param string $plainText Texto plano a cifrar
     * @return string Payload empaquetado y seguro para BD
     */
    public static function encrypt(string $plainText): string
    {
        // Si está vacío, no ciframos nada para evitar procesado inútil
        if ($plainText === '') {
            return '';
        }

        $key = self::getKey();
        
        // GCM recomienda un IV de 12 bytes (96 bits)
        $ivLength = openssl_cipher_iv_length(self::CIPHER);
        $iv = openssl_random_pseudo_bytes($ivLength);
        
        $tag = '';
        $cipherText = openssl_encrypt(
            $plainText, 
            self::CIPHER, 
            $key, 
            OPENSSL_RAW_DATA, 
            $iv, 
            $tag
        );

        if ($cipherText === false) {
            throw new \RuntimeException('Fallo al cifrar los datos.');
        }

        // Empaquetar todo en Base64 para almacenar como texto seguro en MySQL
        return sprintf(
            '%s:%s:%s:%s',
            self::VERSION,
            base64_encode($iv),
            base64_encode($tag),
            base64_encode($cipherText)
        );
    }

    /**
     * Descifra un payload empaquetado. 
     * Valida el Tag de autenticación para asegurar que nadie alteró el texto en la BD.
     * 
     * @param string $payload La cadena cifrada extraída de la BD
     * @return string El texto original descifrado
     */
    public static function decrypt(string $payload): string
    {
        // Si viene vacío o no tiene el formato esperado, retornamos tal cual (o vacío)
        if (empty($payload) || strpos($payload, self::VERSION . ':') !== 0) {
            return $payload; // Retornamos original por si hay datos legados no cifrados accidentalmente
        }

        $parts = explode(':', $payload);
        if (count($parts) !== 4) {
            throw new \RuntimeException('Formato de cifrado inválido.');
        }

        list($version, $ivB64, $tagB64, $cipherTextB64) = $parts;

        // Estrategia de versionado: Si en el futuro cambiamos a v2, manejamos la lógica aquí.
        if ($version !== self::VERSION) {
            throw new \RuntimeException('Versión de cifrado no soportada: ' . $version);
        }

        $key = self::getKey();
        $iv = base64_decode($ivB64);
        $tag = base64_decode($tagB64);
        $cipherText = base64_decode($cipherTextB64);

        $plainText = openssl_decrypt(
            $cipherText, 
            self::CIPHER, 
            $key, 
            OPENSSL_RAW_DATA, 
            $iv, 
            $tag
        );

        if ($plainText === false) {
            // Esto ocurre si la clave es incorrecta O si el texto fue manipulado maliciosamente
            throw new \RuntimeException('Fallo al descifrar. Tag de autenticación inválido o clave incorrecta.');
        }

        return $plainText;
    }
}
