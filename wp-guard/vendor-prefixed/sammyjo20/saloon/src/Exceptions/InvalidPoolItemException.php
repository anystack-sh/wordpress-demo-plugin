<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Exceptions;

class InvalidPoolItemException extends SaloonException
{
    public function __construct()
    {
        parent::__construct('You have provided an invalid request type into the pool. The pool instance only accepts instances of Saloon\Http\Request or GuzzleHttp\Promise\PromiseInterface. You may provide an array, a generator or a callable that provides an array or generator.');
    }
}
