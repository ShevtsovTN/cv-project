<?php

namespace App\Http\Middleware\CustomMiddleware;

class ProviderOneApiMiddleware
{
    public function __invoke($httpClient)
    {
        return $httpClient->withToken(config('api.ProviderOne.token'));
    }
}
