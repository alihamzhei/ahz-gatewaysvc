<?php

namespace App\Services;


class GatewayService
{
    public string $url;
    public int $timeout;
    public int $port;

    /**
     * get url
     *
     * @return string
     */
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * get timeout
     *
     * @return int
     */
    public function getTimeout(): int
    {
        return $this->timeout;
    }

    /**
     * get port
     * @return int
     */
    public function getPort(): int
    {
        return $this->port;
    }

    /**
     * get full url
     *
     * @return string
     */
    public function getFullUrl(): string
    {
        return $this->getUrl() . ':' . $this->getPort();
    }
}
