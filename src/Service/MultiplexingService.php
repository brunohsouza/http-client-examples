<?php

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;

class MultiplexingService
{

    /**
     * @var HttpClientInterface
     */
    private HttpClientInterface $httpClient;

    public function __construct(HttpClientInterface $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    public function downloadUbuntu()
    {
        $url = 'https://releases.ubuntu.com/18.04.1/ubuntu-18.04.1-desktop-amd64.iso';
        $response = $this->httpClient->request('GET', $url);

        // Responses are lazy: this code is executed as soon as headers are received
        if (200 !== $response->getStatusCode()) {
            throw new \Exception('...');
        }

        // response chunks implement Symfony\Contracts\HttpClient\ChunkInterface
        $fileHandler = fopen('/ubuntu.iso', 'w');
        foreach ($this->httpClient->stream($response) as $chunk) {
            if ($chunk->isFirst()) {
                // headers of $response just arrived
                $response->getHeaders();
            } elseif ($chunk->isLast()) {
                // the full content of $response just completed
                fwrite($fileHandler, $chunk->getContent());
            } else {
                // $chunk->getContent() will return a piece
                $chunk->getContent();
            }
        }
    }
}