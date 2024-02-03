<?php

namespace App\Providers;

// use Illuminate\Support\Facades\Gate;
use App\Contracts\Repositories\GatewayConfigRepositoryInterface;
use App\Services\AuthService;
use Illuminate\Foundation\Support\Providers\AuthServiceProvider as ServiceProvider;

class AuthServiceProvider extends ServiceProvider
{
    /**
     * The model to policy mappings for the application.
     *
     * @var array<class-string, class-string>
     */
    protected $policies = [
        //
    ];

    public function register(): void
    {
        $this->app->bind('auth-service' , function (){
            $authService = app(GatewayConfigRepositoryInterface::class);

            return new AuthService($authService->get('authsvc'));
        });
    }

    /**
     * Register any authentication / authorization services.
     */
    public function boot(): void
    {
        //
    }
}
