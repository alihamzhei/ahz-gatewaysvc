<?php

namespace App\Providers;

use App\Contracts\Repositories\GatewayConfigRepositoryInterface;
use App\Repositories\GatewayConfigRepository;
use Illuminate\Support\ServiceProvider;

class GatewayServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        $this->app->bind(GatewayConfigRepositoryInterface::class , function (){
            return new GatewayConfigRepository();
        });
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
