<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

interface IntegerStore
{
    /**
     * Set a value inside the repository
     *
     * @param int|null $value
     * @return $this
     */
    public function set(?int $value): static;

    /**
     * Retrieve all in the repository
     *
     * @return int|null
     */
    public function get(): ?int;

    /**
     * Determine if the repository is empty
     *
     * @return bool
     */
    public function isEmpty(): bool;

    /**
     * Determine if the repository is not empty
     *
     * @return bool
     */
    public function isNotEmpty(): bool;
}
