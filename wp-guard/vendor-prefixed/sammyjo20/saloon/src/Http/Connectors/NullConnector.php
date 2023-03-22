<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Connectors;

use Anystack\WPGuard\V001\Saloon\Http\Connector;

class NullConnector extends Connector
{
    /**
     * Define the base URL of the API.
     *
     * @return string
     */
    public function resolveBaseUrl(): string
    {
        return '';
    }
}
