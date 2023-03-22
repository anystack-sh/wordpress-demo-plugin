<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Exceptions;

class NoMockResponseFoundException extends SaloonException
{
    public function __construct()
    {
        parent::__construct('Saloon was unable to guess a mock response for your request, consider using a wildcard url mock or a connector mock.');
    }
}
