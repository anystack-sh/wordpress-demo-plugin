<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

interface Arrayable
{
    /**
     * Convert the instance to an array
     *
     * @return array<array-key, mixed>
     */
    public function toArray(): array;
}
