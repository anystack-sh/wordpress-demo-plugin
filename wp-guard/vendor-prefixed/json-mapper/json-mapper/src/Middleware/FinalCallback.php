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

class FinalCallback implements MiddlewareInterface
{
    /** @var int */
    private static $nestingLevel = 0;

    /** @var callable */
    private $callback;
    /** @var bool */
    private $onlyApplyCallBackOnTopLevel;

    public function __construct(callable $callback, bool $onlyApplyCallBackOnTopLevel = true)
    {
        $this->callback = $callback;
        $this->onlyApplyCallBackOnTopLevel = $onlyApplyCallBackOnTopLevel;
    }

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
            self::$nestingLevel++;
            $handler($json, $object, $map, $mapper);
            self::$nestingLevel--;

            if (! $this->onlyApplyCallBackOnTopLevel || self::$nestingLevel === 0) {
                \call_user_func($this->callback, $json, $object, $map, $mapper);
            }
        };
    }
}
