<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Helpers;

use ReflectionClass;
use Anystack\WPGuard\V001\Saloon\Contracts\Request;
use Anystack\WPGuard\V001\Saloon\Contracts\Connector;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;

class PluginHelper
{
    /**
     * Boot a given plugin/trait
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Connector|Request $resource
     * @param class-string $trait
     * @return void
     * @throws \ReflectionException
     */
    public static function bootPlugin(PendingRequest $pendingRequest, Connector|Request $resource, string $trait): void
    {
        $traitReflection = new ReflectionClass($trait);

        $bootMethodName = 'boot' . $traitReflection->getShortName();

        if (! method_exists($resource, $bootMethodName)) {
            return;
        }

        $resource->{$bootMethodName}($pendingRequest);
    }
}
