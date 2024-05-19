<?php

namespace App\Http\Middleware\CustomMiddleware;

use Illuminate\Support\Facades\Cache;

class ProviderTwoApiMiddleware
{
    public function __invoke($httpClient)
    {
        return $httpClient->withToken(Cache::get('providerTwoAuthToken'));
    }
}
