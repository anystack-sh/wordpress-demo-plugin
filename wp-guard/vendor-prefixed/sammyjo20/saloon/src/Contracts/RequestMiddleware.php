<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

interface RequestMiddleware
{
    /**
     * Register a request middleware
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest|SimulatedResponsePayload|void
     */
    public function __invoke(PendingRequest $pendingRequest);
}
