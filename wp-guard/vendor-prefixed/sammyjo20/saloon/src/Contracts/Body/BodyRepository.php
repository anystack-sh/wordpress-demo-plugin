<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts\Body;

use Stringable;

interface BodyRepository extends Stringable
{
    /**
     * Set a value inside the repository
     *
     * @param mixed $value
     * @return $this
     */
    public function set(mixed $value): static;

    /**
     * Retrieve all in the repository
     *
     * @return mixed
     */
    public function all(): mixed;

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
