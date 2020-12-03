<?php

declare(strict_types=1);

namespace App\Service;

use Psr\Log\LoggerInterface;
use Symfony\Contracts\HttpClient\Exception\ClientExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\RedirectionExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\ServerExceptionInterface;
use Symfony\Contracts\HttpClient\Exception\TransportExceptionInterface;
use Symfony\Contracts\HttpClient\HttpClientInterface;

class RetryFailedExampleService
{

    private HttpClientInterface $client;
    private LoggerInterface $logger;

    public function __construct(HttpClientInterface $httpClient, LoggerInterface $logger)
    {
        $this->client = $httpClient;
        $this->logger = $logger;
    }

    public function executeRequest()
    {
        try {
            $response = $this->client->request(
                'GET',
                'http://httpstat.us/500',
                [
                    'headers' => ['Content-type' => 'application/json']
                ]
            );

            return $response->toArray();
        } catch (ClientExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        } catch (RedirectionExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        } catch (ServerExceptionInterface $e) {
            $this->logger->error($e->getMessage());

            return [
                'retry_count' => $e->getResponse()->getInfo('retry_count'),
                'status_code' => $e->getResponse()->getStatusCode()
            ];

        } catch (TransportExceptionInterface $e) {
            $this->logger->error($e->getMessage());
        }
    }
}