<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http;

use Anystack\WPGuard\V001\Saloon\Contracts\Connector;
use Anystack\WPGuard\V001\Saloon\Traits\Request\HasConnector;
use Anystack\WPGuard\V001\Saloon\Http\Connectors\NullConnector;

abstract class SoloRequest extends Request
{
    use HasConnector;

    /**
     * Create a new connector instance.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Connector
     */
    protected function resolveConnector(): Connector
    {
        return new NullConnector;
    }
}
