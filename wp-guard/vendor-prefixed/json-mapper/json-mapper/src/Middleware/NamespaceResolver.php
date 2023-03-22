<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Middleware;

use Anystack\WPGuard\V001\JsonMapper\Cache\NullCache;
use Anystack\WPGuard\V001\JsonMapper\Enums\ScalarType;
use Anystack\WPGuard\V001\JsonMapper\Helpers\UseStatementHelper;
use Anystack\WPGuard\V001\JsonMapper\JsonMapperInterface;
use Anystack\WPGuard\V001\JsonMapper\Parser\Import;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\Property;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyMap;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyType;
use Anystack\WPGuard\V001\JsonMapper\Wrapper\ObjectWrapper;
use Psr\SimpleCache\CacheInterface;

class NamespaceResolver extends AbstractMiddleware
{
    /** @var CacheInterface */
    private $cache;

    public function __construct(CacheInterface $cache = null)
    {
        $this->cache = $cache ?? new NullCache();
    }

    public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void {
        foreach ($this->fetchPropertyMapForObject($object, $propertyMap) as $property) {
            $propertyMap->addProperty($property);
        }
    }

    private function fetchPropertyMapForObject(ObjectWrapper $object, PropertyMap $originalPropertyMap): PropertyMap
    {
        $cacheKey = \sprintf(
            '%sCache%s',
            str_replace(['{', '}', '(', ')', '/', '\\', '@', ':' ], '', __CLASS__),
            str_replace(['{', '}', '(', ')', '/', '\\', '@', ':' ], '', $object->getName())
        );
        if ($this->cache->has($cacheKey)) {
            return $this->cache->get($cacheKey);
        }

        $intermediatePropertyMap = new PropertyMap();
        $imports = UseStatementHelper::getImports($object->getReflectedObject());

        /** @var Property $property */
        foreach ($originalPropertyMap as $property) {
            $types = $property->getPropertyTypes();
            foreach ($types as $index => $type) {
                $types[$index] = $this->resolveSingleType($type, $object, $imports);
            }
            $intermediatePropertyMap->addProperty($property->asBuilder()->setTypes(...$types)->build());
        }

        $this->cache->set($cacheKey, $intermediatePropertyMap);

        return $intermediatePropertyMap;
    }

    /** @param Import[] $imports */
    private function resolveSingleType(PropertyType $type, ObjectWrapper $object, array $imports): PropertyType
    {
        if (ScalarType::isValid($type->getType())) {
            return $type;
        }

        $pos = strpos($type->getType(), '\\');
        if ($pos === false) {
            $pos = strlen($type->getType());
        }
        $nameSpacedFirstChunk = '\\' . substr($type->getType(), 0, $pos);

        $matches = \array_filter(
            $imports,
            static function (Import $import) use ($nameSpacedFirstChunk) {
                if ($import->hasAlias() && '\\' . $import->getAlias() === $nameSpacedFirstChunk) {
                    return true;
                }

                return $nameSpacedFirstChunk === \substr($import->getImport(), -strlen($nameSpacedFirstChunk));
            }
        );

        if (count($matches) > 0) {
            $match = \array_shift($matches);
            if ($match->hasAlias()) {
                $strippedType = \substr($type->getType(), strlen($nameSpacedFirstChunk));
                $fullyQualifiedType = $match->getImport() . '\\' . $strippedType;
            } else {
                $strippedMatch = \substr($match->getImport(), 0, -strlen($nameSpacedFirstChunk));
                $fullyQualifiedType = $strippedMatch . '\\' . $type->getType();
            }

            return new PropertyType(rtrim($fullyQualifiedType, '\\'), $type->getArrayInformation());
        }

        $reflectedObject = $object->getReflectedObject();
        while (true) {
            if (class_exists($reflectedObject->getNamespaceName() . '\\' . $type->getType())) {
                return new PropertyType(
                    $reflectedObject->getNamespaceName() . '\\' . $type->getType(),
                    $type->getArrayInformation()
                );
            }

            $reflectedObject = $reflectedObject->getParentClass();
            if (! $reflectedObject) {
                break;
            }
        }

        return $type;
    }
}
