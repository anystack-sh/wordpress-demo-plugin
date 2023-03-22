<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\RequestProperties;

use Anystack\WPGuard\V001\Saloon\Repositories\IntegerStore;

trait HasDelay
{
    /**
     * Request Delay
     *
     * @var IntegerStore
     */
    protected IntegerStore $delay;

    /**
     * Delay repository
     *
     * @return \Anystack\WPGuard\V001\Saloon\Repositories\IntegerStore
     */
    public function delay(): IntegerStore
    {
        return $this->delay ??= new IntegerStore($this->defaultDelay());
    }

    /**
     * Default Delay
     *
     * @return ?int
     */
    protected function defaultDelay(): ?int
    {
        return null;
    }
}
