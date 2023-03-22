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

trait HasConfig
{
    /**
     * Request Config
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    protected ArrayStoreContract $config;

    /**
     * Access the config
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    public function config(): ArrayStoreContract
    {
        return $this->config ??= new ArrayStore($this->defaultConfig());
    }

    /**
     * Default Config
     *
     * @return array<string, mixed>
     */
    protected function defaultConfig(): array
    {
        return [];
    }
}
