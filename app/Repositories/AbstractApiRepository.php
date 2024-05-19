<?php

namespace App\Repositories;

use Exception;
use Illuminate\Http\Client\PendingRequest;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Str;
use RuntimeException;
use Symfony\Component\HttpFoundation\Response as ResponseCode;
use Illuminate\Http\Client\Response;

class AbstractApiRepository
{
    protected PendingRequest $httpClient;

    public function __construct(PendingRequest $httpClient)
    {
        $this->httpClient = $httpClient;
    }

    protected function getHttpClient(): PendingRequest
    {
        return $this->httpClient;
    }

    public const DEFAULT_MIDDLEWARES = [

    ];

    public function getStaticApiEndpoints(): array
    {
        return static::API_ENDPOINTS;
    }

    /**
     * @throws Exception
     */
    public function __call(string $name, array $arguments)
    {
        $apiEndpoints = $this->getStaticApiEndpoints();
        if (! empty($apiEndpoints[$name])) {
            $httpClient = $this->getHttpClient();
            $requestObj = $apiEndpoints[$name];

            $requestObj['middleware'] = isset($requestObj['middleware'])
                ? [...self::DEFAULT_MIDDLEWARES, ...$requestObj['middleware']]
                : [...self::DEFAULT_MIDDLEWARES];

            $httpClient = $this->applyMiddlewares($httpClient, $requestObj['middleware']);

            $method = match (strtolower($requestObj['method'])) {
                'post' => 'post',
                'get' => 'get',
                'delete' => 'delete',
                'put' => 'put',
                'patch' => 'patch',
                default => throw new RuntimeException(
                    'Method not found: '.$requestObj['method'],
                    ResponseCode::HTTP_NOT_FOUND
                )
            };

            $url = '/'.$requestObj['endpoint'];

            $httpClient = $this->configureRequestParameters(
                $httpClient,
                $arguments[1] ?? [],
                $arguments[2] ?? []
            );

            if (! empty($arguments[0])) {
                $httpClient = $this->handleRequestData($httpClient, $arguments[0]);
            }

            if (Str::endsWith($name, 'Sync')) {
                return $this->handleResponse(
                    $httpClient
                        ->{$method}(
                            $url,
                            $arguments[0] ?? []
                        )
                );
            }

            return $httpClient
                ->async()
                ->{$method}(
                    $url,
                    $arguments[0] ?? []
                )
                ->then(function ($response) {
                    return $this->handleResponse(
                        $response
                    );
                });
        }
        throw new RuntimeException($name.' not found in '.static::class, ResponseCode::HTTP_NOT_FOUND);
    }

    private function handleResponse($response)
    {
        if ($response instanceof Response) {
            return $this->processSuccessfulResponse($response);
        }
        throw new RuntimeException('Operation failed: '.$response->getMessage(), $response->getCode());
    }

    private function processSuccessfulResponse(Response $response)
    {
        if ($response->successful()) {
            return Str::isJson($response->body()) ? $response->json() : $response->body();
        }
        throw new RuntimeException('API Request Failed: '.$response->body(), $response->status());
    }

    protected function applyMiddlewares(PendingRequest $httpClient, array $middlewares): PendingRequest
    {
        return array_reduce($middlewares, static function ($client, $middleware) {
            return (new $middleware())($client);
        }, $httpClient);
    }

    protected function handleRequestData(PendingRequest $httpClient, array $requestData): PendingRequest
    {
        foreach ($requestData as $key => $file) {
            if ($file instanceof UploadedFile) {
                $httpClient->attach($key, $file->getContent(), $file->getClientOriginalName());
            }
        }

        return $httpClient;
    }

    protected function configureRequestParameters(
        PendingRequest $httpClient,
        array $urlParameters = [],
        array $queryParameters = []
    ): PendingRequest {
        if (! empty($urlParameters)) {
            $httpClient->withUrlParameters($urlParameters);
        }
        if (! empty($queryParameters)) {
            $httpClient->withQueryParameters($queryParameters);
        }

        return $httpClient;
    }
}
