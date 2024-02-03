<?php

namespace App\Http\Middleware;

use App\Contracts\Repositories\GatewayConfigRepositoryInterface;
use App\Facades\AuthService;
use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class GatewayServiceAuthentication
{
    public function __construct(public GatewayConfigRepositoryInterface $configRepository)
    {
    }
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(Request): (Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $endpoint =  $request->route()->parameter('endpoint');

        $authenticated = $this->authenticate($request);

        if (!str_starts_with($endpoint, 'private')) {
            return $next($request);
        }


        if ($authenticated){
            abort(404);
        };

        return $next($request);
    }

    /**
     * authenticate
     *
     * @param Request $request
     * @return bool|void
     */
    public function authenticate(Request $request)
    {
        if ($authorization = $request->headers->get('Authorization')){
            $userResponse = AuthService::getMe([
                'Authorization' => $authorization
            ]);

            if ($userResponse){
                $request->headers->add([
                    'user-info' => json_encode($userResponse)
                ]);

                return true;
            }

            return false;
        }
    }
}
