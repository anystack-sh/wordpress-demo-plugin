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

class ValueTransformation extends AbstractMiddleware
{
    /** @var callable */
    private $mapFunction;

    /** @var bool */
    private $includeKey;

    public function __construct(callable $mapFunction, bool $includeKey = false)
    {
        $this->mapFunction = $mapFunction;
        $this->includeKey = $includeKey;
    }

    public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void {
        $mapFunction = $this->mapFunction;

        foreach ((array) $json as $key => $value) {
            if ($this->includeKey) {
                $json->$key = $mapFunction($key, $value);
                continue;
            }

            $json->$key = $mapFunction($value);
        }
    }
}
