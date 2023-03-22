<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Auth;

use Anystack\WPGuard\V001\Saloon\Contracts\Authenticator;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Anystack\WPGuard\V001\Saloon\Exceptions\MissingAuthenticatorException;

trait RequiresAuth
{
    /**
     * Throw an exception if an authenticator is not on the request while it is booting.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingSaloonRequest
     * @return void
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\MissingAuthenticatorException
     */
    public function bootRequiresAuth(PendingRequest $pendingSaloonRequest): void
    {
        $authenticator = $pendingSaloonRequest->getAuthenticator();

        if (! $authenticator instanceof Authenticator) {
            throw new MissingAuthenticatorException($this->getRequiresAuthMessage($pendingSaloonRequest));
        }
    }

    /**
     * Default message.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return string
     */
    protected function getRequiresAuthMessage(PendingRequest $pendingRequest): string
    {
        return sprintf('The "%s" request requires authentication.', $pendingRequest->getRequest()::class);
    }
}
