<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Middleware;

use Anystack\WPGuard\V001\JsonMapper\JsonMapperInterface;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyMap;
use Anystack\WPGuard\V001\JsonMapper\Wrapper\ObjectWrapper;

abstract class AbstractMiddleware implements MiddlewareInterface, MiddlewareLogicInterface
{
    public function __invoke(callable $handler): callable
    {
        return function (
            \stdClass $json,
            ObjectWrapper $object,
            PropertyMap $map,
            JsonMapperInterface $mapper
        ) use (
            $handler
        ) {
            $this->handle($json, $object, $map, $mapper);

            $handler($json, $object, $map, $mapper);
        };
    }

    abstract public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void;
}
