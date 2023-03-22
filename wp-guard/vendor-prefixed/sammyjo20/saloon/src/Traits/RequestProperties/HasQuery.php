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

trait HasQuery
{
    /**
     * Request Query Parameters
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    protected ArrayStoreContract $query;

    /**
     * Access the query parameters
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    public function query(): ArrayStoreContract
    {
        return $this->query ??= new ArrayStore($this->defaultQuery());
    }

    /**
     * Default Query Parameters
     *
     * @return array<string, mixed>
     */
    protected function defaultQuery(): array
    {
        return [];
    }
}
