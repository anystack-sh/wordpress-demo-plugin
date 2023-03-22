<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Exceptions;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class InvalidResponseClassException extends SaloonException
{
    /**
     * Constructor
     *
     * @param string|null $message
     */
    public function __construct(string $message = null)
    {
        parent::__construct($message ?? sprintf('The provided response must exist and implement the %s contract.', Response::class));
    }
}
