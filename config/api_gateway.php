<?php

return [
    'base_url'      => env('API_GATEWAY_BASE_URL'),
    'client_id'     => env('API_GATEWAY_CLIENT_ID'),
    'client_secret' => env('API_GATEWAY_CLIENT_SECRET'),
    'token_url'     => env('API_GATEWAY_TOKEN_URL', env('API_GATEWAY_BASE_URL') . '/oauth/token'),
    'cache_ttl'     => 3300, // in seconds, default: 55 min
];
