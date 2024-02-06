<?php

namespace App\Services;


use Symfony\Component\HttpFoundation\Exception\BadRequestException;

class GatewayService
{
    public static string $url;
    public static ?string $timeout;
    public static ?string $port;
    public static bool $exists = false;

    /**
     * service
     * @param string $service
     * @return GatewayService
     */
    public static function service(string $service): GatewayService
    {
        $service = config('gateway.services.'.$service);

        if ( ! $service) {
            throw new BadRequestException('service is not found');
        }

        static::$exists = true;
        static::$url = $service['url'];
        static::$port = $service['port'] ?? null;
        static::$timeout = $service['timeout'] ?? null;

        return new self();
    }

    public function getUrl(): string
    {
        return static::$url;
    }

    /**
     * get timeout
     *
     * @return int
     */
    public function getTimeout(): int
    {
        return static::$timeout;
    }

    /**
     * get port
     * @return bool
     */
    public function exists(): bool
    {
        return static::$exists;
    }

    /**
     * get port
     * @return int
     */
    public function getPort(): int
    {
        return static::$port;
    }

    /**
     * get full url
     *
     * @return string
     */
    public function getFullUrl(): string
    {
        return $this->getUrl().':'.$this->getPort();
    }
}
