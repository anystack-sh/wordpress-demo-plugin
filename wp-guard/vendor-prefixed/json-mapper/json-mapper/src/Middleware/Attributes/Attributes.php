<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Middleware\Attributes;

use Anystack\WPGuard\V001\JsonMapper\JsonMapperInterface;
use Anystack\WPGuard\V001\JsonMapper\Middleware\AbstractMiddleware;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyMap;
use Anystack\WPGuard\V001\JsonMapper\Wrapper\ObjectWrapper;

class Attributes extends AbstractMiddleware
{
    public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void {
        foreach ($object->getReflectedObject()->getProperties() as $property) {
            $attributes = $property->getAttributes(MapFrom::class);

            foreach ($attributes as $attribute) {
                /** @var MapFrom $mapFrom */
                $mapFrom = $attribute->newInstance();
                $source = $mapFrom->source;
                $target = $property->name;

                if ($source === $target) {
                    continue;
                }

                if (isset($json->$source)) {
                    $json->$target = $json->$source;
                    unset($json->$source);
                }
            }
        }
    }
}
