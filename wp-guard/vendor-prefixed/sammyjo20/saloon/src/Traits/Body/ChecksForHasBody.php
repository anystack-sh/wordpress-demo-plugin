<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Body;

use Anystack\WPGuard\V001\Saloon\Http\PendingRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Body\HasBody;
use Anystack\WPGuard\V001\Saloon\Exceptions\BodyException;

trait ChecksForHasBody
{
    /**
     * Check if the request or connector has the WithBody class.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Http\PendingRequest $pendingRequest
     * @return void
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\BodyException
     */
    public function bootChecksForHasBody(PendingRequest $pendingRequest): void
    {
        if ($pendingRequest->getRequest() instanceof HasBody || $pendingRequest->getConnector() instanceof HasBody) {
            return;
        }

        throw new BodyException(sprintf('You have added a body trait without implementing `%s` on your request or connector.', HasBody::class));
    }
}
