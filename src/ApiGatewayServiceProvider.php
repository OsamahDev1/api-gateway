<?php

namespace Osamahdev1\ApiGateway;

use Illuminate\Support\ServiceProvider;

class ApiGatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/api_gateway.php', 'api_gateway');

        $this->app->singleton('api-gateway', function ($app) {
            return new ApiGateway(config('api_gateway'));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/api_gateway.php' => config_path('api_gateway.php'),
        ], 'config');
    }
}
