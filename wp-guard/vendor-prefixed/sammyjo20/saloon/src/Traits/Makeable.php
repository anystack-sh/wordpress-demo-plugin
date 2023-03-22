<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits;

trait Makeable
{
    /**
     * Instantiate a new class with the arguments.
     *
     * @param mixed ...$arguments
     * @return static
     */
    public static function make(mixed ...$arguments): static
    {
        return new static(...$arguments);
    }
}
