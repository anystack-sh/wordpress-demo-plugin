<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

use Throwable;

interface CanThrowRequestExceptions
{
    /**
     * Determine if the request has failed.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return bool|null
     */
    public function hasRequestFailed(Response $response): ?bool;

    /**
     * Determine if we should throw an exception if the `$response->throw()` ({@see \Saloon\Contracts\Response::throw()})
     * is used, or when AlwaysThrowOnErrors is used.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return bool
     */
    public function shouldThrowRequestException(Response $response): bool;

    /**
     * Get the request exception.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @param \Throwable|null $senderException
     * @return \Throwable|null
     */
    public function getRequestException(Response $response, ?Throwable $senderException): ?Throwable;
}
