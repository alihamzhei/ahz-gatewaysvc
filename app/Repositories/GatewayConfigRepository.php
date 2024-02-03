<?php

namespace App\Repositories;

use App\Contracts\Repositories\GatewayConfigRepositoryInterface;
use App\Services\GatewayService;

class GatewayConfigRepository implements GatewayConfigRepositoryInterface
{
    public array $config = [];

    public function __construct()
    {
        $this->config = config('gateway.services');
    }

    /**
     * Exist service
     *
     * @param string $service
     * @return bool
     */
    public function exist(string $service): bool
    {
        return in_array($service, array_keys($this->config));
    }


    /**
     * get
     *
     * @param string $service
     * @return GatewayService|null
     */
    public function get(string $service): ?GatewayService
    {
        if ($this->exist($service)) {
            $gatewayService = new GatewayService();

            $gatewayService->url = $this->config[$service]['url'];
            $gatewayService->port = $this->config[$service]['port'];
            $gatewayService->timeout = $this->config[$service]['timeout'];

            return $gatewayService;
        }

        return null;
    }
}
