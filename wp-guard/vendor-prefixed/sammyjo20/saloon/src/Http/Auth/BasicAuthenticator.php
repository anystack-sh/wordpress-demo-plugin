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

class BasicAuthenticator implements Authenticator
{
    /**
     * @param string $username
     * @param string $password
     */
    public function __construct(
        public string $username,
        public string $password,
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
        $pendingRequest->config()->add('auth', [$this->username, $this->password]);
    }
}
