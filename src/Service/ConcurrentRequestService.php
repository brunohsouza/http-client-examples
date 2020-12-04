<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class ConcurrentRequestService
{
    private HttpClientInterface $httpClient;

    public function __construct(
        HttpClientInterface $httpClient
    ) {
        $this->httpClient = $httpClient;
    }

    public function executeConcurrentRequestsWithHttp2()
    {
        $startTime = microtime(true);
        try {
            $responses = [];
            for ($i = 0; $i < 379; ++$i) {
                $uri = "https://http2.akamai.com/demo/tile-$i.png";
                $responses[] = $this->httpClient->request('GET', $uri);
            }

            $content = '';
            foreach ($responses as $response) {
                $content = $response->getContent();
            }

            $endTime = microtime(true);
            $totalTime = $endTime - $startTime;
            return 'Process Time 379 requests with HTTP2: ' . $totalTime . PHP_EOL;
        } catch (\Exception $exception) {
            throw $exception;
        }
    }
}