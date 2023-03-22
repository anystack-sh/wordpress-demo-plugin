<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Plugins;

use Anystack\WPGuard\V001\Saloon\Enums\Timeout;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;

trait HasTimeout
{
    /**
     * Boot HasTimeout plugin.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function bootHasTimeout(PendingRequest $pendingRequest): void
    {
        $pendingRequest->config()->merge([
            'connect_timeout' => $this->getConnectTimeout(),
            'timeout' => $this->getRequestTimeout(),
        ]);
    }

    /**
     * Get the request connection timeout.
     *
     * @return float
     */
    public function getConnectTimeout(): float
    {
        return property_exists($this, 'connectTimeout') ? $this->connectTimeout : Timeout::CONNECT->value;
    }

    /**
     * Get the request timeout.
     *
     * @return float
     */
    public function getRequestTimeout(): float
    {
        return property_exists($this, 'requestTimeout') ? $this->requestTimeout : Timeout::REQUEST->value;
    }
}
