<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Plugins;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;

trait AlwaysThrowOnErrors
{
    /**
     * Boot AlwaysThrowOnErrors Plugin
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public static function bootAlwaysThrowOnErrors(PendingRequest $pendingRequest): void
    {
        $pendingRequest->middleware()->onResponse(fn (Response $response) => $response->throw());
    }
}
