<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Data;

use Closure;

class Pipe
{
    public readonly Closure $callable;

    /**
     * Constructor
     *
     * @param callable(mixed $payload): (mixed) $callable
     * @param string|null $name
     */
    public function __construct(
        callable $callable,
        readonly public ?string $name = null,
    ) {
        $this->callable = $callable(...);
    }
}
