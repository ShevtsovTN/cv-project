<?php

namespace App\Http\Middleware\CustomMiddleware;

use Illuminate\Http\Client\PendingRequest;

class ProviderTwoCredentialsMiddleware
{
    public function __invoke(PendingRequest $httpClient): PendingRequest
    {
        return $httpClient->withBasicAuth(
            config('api.ProviderTwo.email'),
            config('api.ProviderTwo.password')
        );
    }
}
