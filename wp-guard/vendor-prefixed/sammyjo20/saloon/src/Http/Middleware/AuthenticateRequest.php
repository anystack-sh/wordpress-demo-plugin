<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Middleware;

use Anystack\WPGuard\V001\Saloon\Contracts\Authenticator;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\RequestMiddleware;

class AuthenticateRequest implements RequestMiddleware
{
    /**
     * Authenticate the pending request
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function __invoke(PendingRequest $pendingRequest): void
    {
        $authenticator = $pendingRequest->getAuthenticator();

        if ($authenticator instanceof Authenticator) {
            $authenticator->set($pendingRequest);
        }
    }
}
