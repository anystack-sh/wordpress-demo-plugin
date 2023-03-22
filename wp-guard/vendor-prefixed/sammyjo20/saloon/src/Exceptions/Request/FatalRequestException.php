<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Exceptions\Request;

use Throwable;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Anystack\WPGuard\V001\Saloon\Exceptions\SaloonException;

class FatalRequestException extends SaloonException
{
    /**
     * The PendingRequest
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest
     */
    protected PendingRequest $pendingSaloonRequest;

    /**
     * Constructor
     *
     * @param \Throwable $originalException
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     */
    public function __construct(Throwable $originalException, PendingRequest $pendingRequest)
    {
        parent::__construct($originalException->getMessage(), $originalException->getCode(), $originalException);

        $this->pendingSaloonRequest = $pendingRequest;
    }

    /**
     * Get the PendingRequest that caused the exception.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest
     */
    public function getPendingRequest(): PendingRequest
    {
        return $this->pendingSaloonRequest;
    }
}
