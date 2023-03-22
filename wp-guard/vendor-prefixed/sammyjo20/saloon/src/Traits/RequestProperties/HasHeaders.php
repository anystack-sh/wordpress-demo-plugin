<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\RequestProperties;

use Anystack\WPGuard\V001\Saloon\Repositories\ArrayStore;
use Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore as ArrayStoreContract;

trait HasHeaders
{
    /**
     * Request Headers
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    protected ArrayStoreContract $headers;

    /**
     * Access the headers
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    public function headers(): ArrayStoreContract
    {
        return $this->headers ??= new ArrayStore($this->defaultHeaders());
    }

    /**
     * Default Request Headers
     *
     * @return array<string, mixed>
     */
    protected function defaultHeaders(): array
    {
        return [];
    }
}
