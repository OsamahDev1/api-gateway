<?php

namespace Osamahdev1\ApiGateway;

use Illuminate\Support\ServiceProvider;

class ApiGatewayServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/api-gateway.php', 'api-gateway');

        $this->app->singleton('api-gateway', function ($app) {
            return new ApiGateway(config('api-gateway'));
        });
    }

    public function boot()
    {
        $this->publishes([
            __DIR__ . '/../config/api-gateway.php' => config_path('api-gateway.php'),
        ], 'config');
    }
}
