<?php

return [
    'auth_key' => env('APP_AUTH_KEY'),
    'ProviderOne' => [
        'token' => env('EXAMPLE_ONE_API_TOKEN', '1234567890'),
        'url' => env('EXAMPLE_ONE_API_URL', 'https://example-one.com/api/v1/'),
    ],
    'ProviderTwo' => [
        'email' => env('EXAMPLE_TWO_API_EMAIL', ''),
        'password' => env('EXAMPLE_TWO_API_PASSWORD', ''),
        'url' => env('EXAMPLE_TWO_API_URL', 'https://example-two.com/api/v1/'),
    ],
];
