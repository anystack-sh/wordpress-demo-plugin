<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Repositories;

use Anystack\WPGuard\V001\Saloon\Traits\Conditionable;
use Anystack\WPGuard\V001\Saloon\Contracts\IntegerStore as IntegerStoreContract;

class IntegerStore implements IntegerStoreContract
{
    use Conditionable;

    /**
     * store Data
     *
     * @var int|null
     */
    protected ?int $data = null;

    /**
     * Constructor
     *
     * @param int|null $value
     */
    public function __construct(?int $value = null)
    {
        $this->set($value);
    }

    /**
     * Set a value inside the store
     *
     * @param int|null $value
     * @return $this
     */
    public function set(?int $value): static
    {
        $this->data = $value;

        return $this;
    }

    /**
     * Retrieve all in the store
     *
     * @return int|null
     */
    public function get(): ?int
    {
        return $this->data;
    }

    /**
     * Determine if the store is empty
     *
     * @return bool
     */
    public function isEmpty(): bool
    {
        return empty($this->data);
    }

    /**
     * Determine if the store is not empty
     *
     * @return bool
     */
    public function isNotEmpty(): bool
    {
        return ! $this->isEmpty();
    }
}
