<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Auth;

use Anystack\WPGuard\V001\Saloon\Contracts\Authenticator;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;

class TokenAuthenticator implements Authenticator
{
    /**
     * @param string $token
     * @param string $prefix
     */
    public function __construct(
        public string $token,
        public string $prefix = 'Bearer'
    ) {
        //
    }

    /**
     * Apply the authentication to the request.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function set(PendingRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add('Authorization', trim($this->prefix . ' ' . $this->token));
    }
}
