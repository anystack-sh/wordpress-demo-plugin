<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Middleware;

use Anystack\WPGuard\V001\Saloon\Debugging\DebugData;
use Anystack\WPGuard\V001\Saloon\Contracts\HasDebugging;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\RequestMiddleware;

class DebugRequest implements RequestMiddleware
{
    /**
     * Register a request middleware
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function __invoke(PendingRequest $pendingRequest): void
    {
        $connector = $pendingRequest->getConnector();

        if (! $connector instanceof HasDebugging) {
            return;
        }

        $connector->debug()->send(new DebugData($pendingRequest, null));
    }
}
