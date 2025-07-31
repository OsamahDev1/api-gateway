<?php

namespace Osamahdev1\ApiGateway;

use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;

class ApiGateway
{
    protected $config;

    public function __construct(array $config = [])
    {
        $this->config = $config ?: config('api-gateway');
    }

    protected function getBaseUrl()
    {
        return rtrim($this->config['base_url'], '/');
    }

    public function getAccessToken()
    {
        if ($token = Cache::get('api_gateway_access_token')) {
            return $token;
        }

        $response = Http::asForm()->post($this->config['token_url'], [
            'grant_type' => 'client_credentials',
            'client_id' => $this->config['client_id'],
            'client_secret' => $this->config['client_secret'],
        ]);

        $token = $response->json('access_token');
        if (!$token) {
            throw new \Exception('Unable to retrieve access token');
        }

        Cache::put('api_gateway_access_token', $token, $this->config['cache_ttl'] ?? 3300);
        return $token;
    }

    /**
     * Make an API request to the gateway.
     *
     * @param string $method HTTP method ('get', 'post', etc.)
     * @param string $route Endpoint route (e.g. '/users/1')
     * @param array $options HTTP options (query, json, etc.)
     * @return \Illuminate\Http\Client\Response
     */
    public function apiRequest($method, $route, $options = [])
    {
        $token = $this->getAccessToken();
        $url = $this->getBaseUrl() . '/' . ltrim($route, '/');

        return Http::withToken($token)->$method($url, $options);
    }

    // Optional helpers for sugar
    public function get($route, $options = [])
    {
        return $this->apiRequest('get', $route, $options);
    }

    public function post($route, $options = [])
    {
        return $this->apiRequest('post', $route, $options);
    }
}
