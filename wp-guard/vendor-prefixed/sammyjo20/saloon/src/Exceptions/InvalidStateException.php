<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Exceptions;

use Throwable;

class InvalidStateException extends SaloonException
{
    public function __construct(string $message = null, int $code = 0, ?Throwable $previous = null)
    {
        parent::__construct($message ?? 'Invalid state.', $code, $previous);
    }
}
