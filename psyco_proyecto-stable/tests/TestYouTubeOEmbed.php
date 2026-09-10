<?php
/**
 * Simple test script for YouTubeOEmbedService
 * Run with: php tests/TestYouTubeOEmbed.php
 */

require_once __DIR__ . '/../index.php'; // This loads autoloader, EnvLoader, etc.

class TestYouTubeOEmbed
{
    private YouTubeOEmbedService $service;

    public function __construct()
    {
        $this->service = new YouTubeOEmbedService();
    }

    public function run()
    {
        echo "Starting Tests...\n";
        $this->testValidUrl();
        $this->testInvalidUrl();
        $this->testCache();
        echo "All tests completed.\n";
    }

    private function testValidUrl()
    {
        echo "Test: Valid URL... ";
        $url = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        try {
            $dto = $this->service->fetch($url);
            if ($dto->title && $dto->html) {
                echo "PASSED\n";
            } else {
                echo "FAILED (Missing fields)\n";
            }
        } catch (Exception $e) {
            echo "FAILED (" . $e->getMessage() . ")\n";
        }
    }

    private function testInvalidUrl()
    {
        echo "Test: Invalid URL... ";
        $url = 'https://www.example.com/video';
        try {
            $this->service->fetch($url);
            echo "FAILED (Expected InvalidArgumentException)\n";
        } catch (InvalidArgumentException $e) {
            echo "PASSED\n";
        } catch (Exception $e) {
            echo "FAILED (Wrong exception: " . get_class($e) . ")\n";
        }
    }

    private function testCache()
    {
        echo "Test: Cache speed... ";
        $url = 'https://www.youtube.com/watch?v=dQw4w9WgXcQ';
        
        $start = microtime(true);
        $this->service->fetch($url); // Should hit cache
        $duration = microtime(true) - $start;

        if ($duration < 0.1) { // Cache hit should be very fast (<100ms)
            echo "PASSED ({$duration}s)\n";
        } else {
            echo "FAILED (Took too long: {$duration}s)\n";
        }
    }
}

$tester = new TestYouTubeOEmbed();
$tester->run();
