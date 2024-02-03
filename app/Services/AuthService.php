<?php

namespace App\Services;

use Illuminate\Http\Client\PendingRequest;
use Illuminate\Support\Facades\Http;

class AuthService
{
    private PendingRequest $request;

    public function __construct(GatewayService $gatewayService)
    {
        $this->request = Http::baseUrl($gatewayService->getFullUrl());
    }

    public function getMe(array $headers): ?array
    {
        $response = $this->request->withHeaders($headers)->get('/api/me');

        return $response->json();
    }
}
