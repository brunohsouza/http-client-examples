<?php


namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Component\HttpClient\AmpHttpClient;
use Symfony\Component\HttpClient\CurlHttpClient;
use Symfony\Contracts\HttpClient\Exception\HttpExceptionInterface;

class Http2SupportService
{
    private LoggerInterface $logger;

    public function __construct(LoggerInterface $logger)
    {
        $this->logger = $logger;
    }

    public function getAmpHttpClient()
    {
        try {
            $this->client = new AmpHttpClient([
                'base_uri' => 'https://http2.pro'
            ]);

            $response = $this->client->request(
                'GET',
                '/api/v1'
            );

            return [
                'status_code' => $response->getStatusCode(),
                'info' => $response->getInfo('debug')
            ];
        } catch (HttpExceptionInterface $exception) {
            throw $exception->getResponse()->getInfo();
        }
    }

    public function getCurlHttpClient()
    {
        try {
            $client = new CurlHttpClient([
                'base_uri' => 'https://http2.pro'
            ]);

            $response = $client->request(
                'GET',
                '/api/v1'
            );

            return [
                'status_code' => $response->getStatusCode(),
                'info' => $response->getInfo('response_headers')
            ];
        } catch (HttpExceptionInterface $exception) {
            throw $exception->getResponse()->getInfo();
        }
    }
}