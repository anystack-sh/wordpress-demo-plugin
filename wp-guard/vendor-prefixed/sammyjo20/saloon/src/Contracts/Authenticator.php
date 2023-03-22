<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

interface Authenticator
{
    /**
     * Apply the authentication to the request.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function set(PendingRequest $pendingRequest): void;
}
