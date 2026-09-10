<?php

require_once dirname(__DIR__, 2) . '/core/Logger.php';
require_once dirname(__DIR__, 2) . '/core/FileCache.php';

class YouTubeOEmbedService implements OEmbedProviderInterface
{
    private Logger $logger;
    private FileCache $cache;

    public function __construct()
    {
        $this->logger = new Logger('oembed_youtube.log');
        $this->cache = new FileCache(86400); // 24 hours
    }

    public function supports(string $url): bool
    {
        return (bool) preg_match('/^(https?:\/\/)?(www\.)?(youtube\.com|youtu\.be)\/.+$/i', $url);
    }

    public function fetch(string $url): OEmbedDTO
    {
        if (!$this->supports($url)) {
            $this->logger->warning("URL not supported by YouTube provider", ['url' => $url]);
            throw new InvalidArgumentException("URL is not a valid YouTube link.");
        }

        $cacheKey = 'youtube_oembed_' . $url;
        $cachedData = $this->cache->get($cacheKey);

        if ($cachedData !== null) {
            $this->logger->info("Returning cached oEmbed data", ['url' => $url]);
            return $this->createDtoFromArray($cachedData);
        }

        $endpoint = 'https://www.youtube.com/oembed?url=' . urlencode($url) . '&format=json';

        $context = stream_context_create([
            'http' => [
                'method' => 'GET',
                'timeout' => 10,
                'ignore_errors' => true // Permite capturar el body en errores 4xx/5xx
            ]
        ]);

        $response = @file_get_contents($endpoint, false, $context);
        
        if ($response === false) {
            $error = error_get_last();
            $this->logger->error("Network error fetching oEmbed", ['url' => $url, 'error' => $error['message'] ?? 'Unknown error']);
            throw new RuntimeException("Network error while fetching oEmbed data.");
        }

        // Obtener el código HTTP
        $httpCode = 200;
        if (isset($http_response_header) && is_array($http_response_header)) {
            if (preg_match('#HTTP/\d+\.\d+ (\d+)#', $http_response_header[0], $matches)) {
                $httpCode = (int)$matches[1];
            }
        }

        if ($httpCode !== 200) {
            $this->logger->warning("YouTube API returned non-200 status", [
                'url' => $url, 
                'status' => $httpCode,
                'response' => $response
            ]);
            
            if ($httpCode === 404) {
                throw new RuntimeException("YouTube video not found.");
            }
            if ($httpCode === 401 || $httpCode === 403) {
                throw new RuntimeException("YouTube video is private or access is denied.");
            }
            throw new RuntimeException("Unexpected response from YouTube API (Status: $httpCode).");
        }

        $data = json_decode($response, true);
        if (json_last_error() !== JSON_ERROR_NONE) {
            $this->logger->error("Failed to parse YouTube JSON response", [
                'url' => $url, 
                'error' => json_last_error_msg(),
                'response' => $response
            ]);
            throw new RuntimeException("Invalid JSON received from YouTube.");
        }

        if (!isset($data['title'], $data['html'])) {
            $this->logger->error("Missing required fields in YouTube response", ['url' => $url, 'data' => $data]);
            throw new RuntimeException("Malformed oEmbed response from YouTube.");
        }

        $dto = $this->createDtoFromArray($data);
        
        // Cache the raw array, not the DTO object directly, for easier serialization/deserialization
        $this->cache->set($cacheKey, $data);
        
        $this->logger->info("Successfully fetched and cached YouTube oEmbed data", ['url' => $url]);

        return $dto;
    }

    private function createDtoFromArray(array $data): OEmbedDTO
    {
        return new OEmbedDTO(
            title: $data['title'] ?? 'Unknown Title',
            provider_name: $data['provider_name'] ?? 'YouTube',
            provider_url: $data['provider_url'] ?? 'https://www.youtube.com/',
            html: $data['html'] ?? '',
            width: (int)($data['width'] ?? 0),
            height: (int)($data['height'] ?? 0),
            author_name: $data['author_name'] ?? null,
            author_url: $data['author_url'] ?? null,
            thumbnail_url: $data['thumbnail_url'] ?? null,
            thumbnail_width: isset($data['thumbnail_width']) ? (int)$data['thumbnail_width'] : null,
            thumbnail_height: isset($data['thumbnail_height']) ? (int)$data['thumbnail_height'] : null,
            raw_data: $data
        );
    }
}
