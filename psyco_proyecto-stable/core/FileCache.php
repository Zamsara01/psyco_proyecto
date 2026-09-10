<?php
/**
 * Simple file-based cache for Psyco.
 */
class FileCache
{
    private string $cacheDir;
    private int $defaultTtl;

    public function __construct(int $defaultTtl = 86400) // 24 hours
    {
        $this->cacheDir = dirname(__DIR__) . '/storage/cache/';
        if (!is_dir($this->cacheDir)) {
            mkdir($this->cacheDir, 0777, true);
        }
        $this->defaultTtl = $defaultTtl;
    }

    public function get(string $key)
    {
        $file = $this->getCacheFilePath($key);
        
        if (!file_exists($file)) {
            return null;
        }

        $data = file_get_contents($file);
        if ($data === false) {
            return null;
        }

        $cache = json_decode($data, true);
        if (!is_array($cache) || !isset($cache['expires_at'], $cache['value'])) {
            return null;
        }

        if (time() > $cache['expires_at']) {
            $this->delete($key);
            return null;
        }

        return $cache['value'];
    }

    public function set(string $key, $value, ?int $ttl = null): bool
    {
        $file = $this->getCacheFilePath($key);
        $expiresAt = time() + ($ttl ?? $this->defaultTtl);
        
        $cache = [
            'expires_at' => $expiresAt,
            'value' => $value
        ];

        return file_put_contents($file, json_encode($cache), LOCK_EX) !== false;
    }

    public function delete(string $key): bool
    {
        $file = $this->getCacheFilePath($key);
        if (file_exists($file)) {
            return unlink($file);
        }
        return true;
    }

    private function getCacheFilePath(string $key): string
    {
        return $this->cacheDir . md5($key) . '.cache';
    }
}
