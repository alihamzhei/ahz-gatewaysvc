<?php

namespace App\Http\Controllers;


use App\Services\GatewayService;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class GatewayController extends Controller
{
    /**
     * @throws Exception
     */
    public function gateway(string $service, mixed $endpoint, Request $request)
    {
        $serviceConfig = GatewayService::service($service);

        $response = Http::baseUrl($serviceConfig->getFullUrl())
            ->timeout($serviceConfig->getTimeout())
            ->withHeaders([
                'Accept' => $request->headers->get('Accept'),
                'Authorization' => $request->headers->get('Authorization')
            ])
            ->{strtolower($request->getMethod())}($endpoint, $request->all());

        return response($response->body(), $response->status())
            ->header('Content-Type', $response->header('Content-Type'));
    }
}
