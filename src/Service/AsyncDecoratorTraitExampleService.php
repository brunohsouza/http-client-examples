<?php /** @noinspection ALL */

declare(strict_types=1);

namespace App\Service;

use Symfony\Contracts\HttpClient\HttpClientInterface;
use Symfony\Contracts\HttpClient\ResponseInterface;
use Symfony\Contracts\HttpClient\ResponseStreamInterface;
use Symfony\Component\HttpClient\AsyncDecoratorTrait;

class AsyncDecoratorTraitExampleService implements HttpClientInterface
{
    use AsyncDecoratorTrait;

    public function request(string $method, string $url, array $options = []): ResponseInterface
    {
        return new AsyncResponse($method, $url, $options, static function (ChunkInterface $chunk, AsyncContext $context) {
            // do what you want with chunks, e.g. split them
            // in smaller chunks, group them, skip some, etc.
            if ($chunk->isFirst()) {
                // headers of $response just arrived
            } elseif ($chunk->isLast()) {
                // the full content of $response just completed
            } else {
                // $chunk->getContent() will return a piece
            }
            return $context->getResponse();
        });
    }

    public function executeRequest()
    {
        $response = $this->request(
            'GET',
            'http://httpstat.us/200',
            [
                'headers' => ['Content-type' => 'application/json'],
            ]
        )->getContent();
    }

    private static function validateHeaders()
    {

    }


    public function stream($responses, float $timeout = null): ResponseStreamInterface
    {
        // TODO: Implement stream() method.
    }
}
