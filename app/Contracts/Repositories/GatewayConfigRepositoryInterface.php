<?php

namespace App\Contracts\Repositories;

use App\Services\GatewayService;

interface GatewayConfigRepositoryInterface
{
    public function exist(string $service): bool;

    public function get(string $service): ?GatewayService;
}
