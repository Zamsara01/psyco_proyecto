<?php
require_once dirname(__DIR__, 2) . '/core/Controller.php';

/**
 * Controller for API endpoints
 */
class ControllerApi extends Controller
{
    /**
     * Handle oEmbed requests
     * Example: GET /api/oembed/youtube?url=...
     */
    public function oembed(): void
    {
        header('Content-Type: application/json; charset=utf-8');

        // The Router sets $_GET['id'] to the third segment. 
        // e.g., /api/oembed/youtube -> id = youtube
        $provider = $_GET['id'] ?? '';
        $url = $_GET['link'] ?? '';

        if (empty($url)) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => 'The "link" parameter is required.']);
            return;
        }

        if ($provider !== 'youtube') {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => "Unsupported oEmbed provider: {$provider}"]);
            return;
        }

        try {
            $service = new YouTubeOEmbedService();
            $dto = $service->fetch($url);
            
            http_response_code(200);
            echo json_encode(['ok' => true, 'data' => $dto->toArray()]);

        } catch (InvalidArgumentException $e) {
            http_response_code(400);
            echo json_encode(['ok' => false, 'error' => $e->getMessage()]);
        } catch (RuntimeException $e) {
            $msg = $e->getMessage();
            if (str_contains($msg, 'not found')) {
                http_response_code(404);
            } elseif (str_contains($msg, 'private')) {
                http_response_code(401);
            } else {
                http_response_code(500);
            }
            echo json_encode(['ok' => false, 'error' => $msg]);
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['ok' => false, 'error' => 'An unexpected error occurred.']);
        }
    }
}
