<?php
declare(strict_types=1);

namespace App\Services\Emailable;

use RuntimeException;
use GuzzleHttp\Client;
use GuzzleHttp\Middleware;
use GuzzleHttp\HandlerStack;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\ResponseInterface;
use GuzzleHttp\Exception\ConnectException;
use App\Contracts\EmailValidationInterface;


class EmailValidationService implements EmailValidationInterface
{
    private $baseUrl = "https://api.emailable.com/v1/";
    public function __construct(private string $apiKey)
    {

    }

    public function verify(string $email): array
    {
        $stack = HandlerStack::create();

        $maxRetries = 3;

        $stack->push($this->getRetryMiddleware($maxRetries));

        $client = new Client([
            "base_uri"=> $this->baseUrl,
            "timeout"=> 5,
            "handler"=> $stack
        ]);

        $params = [
            "api_key"=> $this->apiKey,
            "email"=> $email
        ];

        $response = $client->get('verify', ['query', $params]);

        return json_decode($response->getBody()->getContents(), true);
    }

    private function getRetryMiddleware(int $maxRetries): callable
    {
        return Middleware::retry(function (int $retries, RequestInterface $request, ?ResponseInterface $response = null, ?RuntimeException $e = null) use ($maxRetries) {
            if ($retries >= $maxRetries) {
                return false;
            }

            if ($response && in_array($response->getStatusCode(), [249, 429, 503])) {
                return true;
            }

            if ($e instanceof ConnectException) {
                return true;
            }

            return false;
        });
    }
}
