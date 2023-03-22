<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Middleware;

use Anystack\WPGuard\V001\JsonMapper\Builders\PropertyBuilder;
use Anystack\WPGuard\V001\JsonMapper\Enums\Visibility;
use Anystack\WPGuard\V001\JsonMapper\JsonMapperInterface;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\ArrayInformation;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyMap;
use Anystack\WPGuard\V001\JsonMapper\Wrapper\ObjectWrapper;
use Psr\SimpleCache\CacheInterface;
use ReflectionNamedType;
use ReflectionUnionType;

class TypedProperties extends AbstractMiddleware
{
    /** @var CacheInterface */
    private $cache;

    public function __construct(CacheInterface $cache)
    {
        $this->cache = $cache;
    }

    public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void {
        $propertyMap->merge($this->fetchPropertyMapForObject($object));
    }

    private function fetchPropertyMapForObject(ObjectWrapper $object): PropertyMap
    {
        $cacheKey = \sprintf(
            '%sCache%s',
            str_replace(['{', '}', '(', ')', '/', '\\', '@', ':' ], '', __CLASS__),
            str_replace(['{', '}', '(', ')', '/', '\\', '@', ':' ], '', $object->getName())
        );
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $reflectionProperties = $object->getReflectedObject()->getProperties();
        $intermediatePropertyMap = new PropertyMap();

        foreach ($reflectionProperties as $reflectionProperty) {
            $type = $reflectionProperty->getType();

            if ($type instanceof ReflectionNamedType) {
                $isArray = $type->getName() === 'array';
                $propertyType = $isArray ? 'mixed' : $type->getName();
                $property = PropertyBuilder::new()
                    ->setName($reflectionProperty->getName())
                    ->addType(
                        $propertyType,
                        $isArray ? ArrayInformation::singleDimension() : ArrayInformation::notAnArray()
                    )
                    ->setIsNullable($type->allowsNull() || ((!$isArray) && $propertyType === 'mixed'))
                    ->setVisibility(Visibility::fromReflectionProperty($reflectionProperty))
                    ->build();
                $intermediatePropertyMap->addProperty($property);

                continue;
            }

            if ($type instanceof ReflectionUnionType) {
                $types = \array_map(static function (ReflectionNamedType $t): string {
                    return $t->getName();
                }, $type->getTypes());
                $isArray = \in_array('array', $types, true);

                $builder = PropertyBuilder::new()
                    ->setName($reflectionProperty->getName())
                    ->setVisibility(Visibility::fromReflectionProperty($reflectionProperty))
                    ->setIsNullable($type->allowsNull());

                /* A union type that has one of its types defined as array is to complex to understand */
                if ($isArray) {
                    $property = $builder->addType('mixed', ArrayInformation::singleDimension())->build();
                    $intermediatePropertyMap->addProperty($property);
                    continue;
                }

                foreach ($types as $type) {
                    $builder->addType($type, ArrayInformation::notAnArray());
                }
                $property = $builder->build();
                $intermediatePropertyMap->addProperty($property);
            }
        }

        $this->cache->set($cacheKey, $intermediatePropertyMap);

        return $intermediatePropertyMap;
    }
}
