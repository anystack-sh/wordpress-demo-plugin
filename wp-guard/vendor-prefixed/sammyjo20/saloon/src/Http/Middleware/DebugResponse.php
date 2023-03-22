<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Middleware;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Debugging\DebugData;
use Anystack\WPGuard\V001\Saloon\Contracts\HasDebugging;
use Anystack\WPGuard\V001\Saloon\Contracts\ResponseMiddleware;

class DebugResponse implements ResponseMiddleware
{
    /**
     * Register a response middleware
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return void
     */
    public function __invoke(Response $response): void
    {
        $pendingRequest = $response->getPendingRequest();
        $connector = $pendingRequest->getConnector();

        if (! $connector instanceof HasDebugging) {
            return;
        }

        $connector->debug()->send(new DebugData($pendingRequest, $response));
    }
}
