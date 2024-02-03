<?php

namespace App\Http\Controllers;


use App\Contracts\Repositories\GatewayConfigRepositoryInterface;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GatewayController extends Controller
{
    public function __construct(public GatewayConfigRepositoryInterface $gatewayConfigRepository)
    {
    }

    /**
     * @throws \Exception
     */
    public function gateway(string $service, mixed $endpoint , Request $request)
    {
        $serviceConfig = $this->gatewayConfigRepository->get($service);

        $response = Http::baseUrl($serviceConfig->getFullUrl())
            ->timeout($serviceConfig->getTimeout())
            ->withHeaders($request->headers->all())
            ->send($request->getMethod(), $endpoint, $request->all());


        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'));
    }
}
