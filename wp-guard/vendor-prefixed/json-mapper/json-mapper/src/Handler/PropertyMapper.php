<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Handler;

use Anystack\WPGuard\V001\JsonMapper\Enums\ScalarType;
use Anystack\WPGuard\V001\JsonMapper\Enums\Visibility;
use Anystack\WPGuard\V001\JsonMapper\Exception\ClassFactoryException;
use Anystack\WPGuard\V001\JsonMapper\Exception\TypeError;
use Anystack\WPGuard\V001\JsonMapper\Helpers\IScalarCaster;
use Anystack\WPGuard\V001\JsonMapper\Helpers\ScalarCaster;
use Anystack\WPGuard\V001\JsonMapper\JsonMapperInterface;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\Property;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyMap;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyType;
use Anystack\WPGuard\V001\JsonMapper\Wrapper\ObjectWrapper;

class PropertyMapper
{
    /** @var FactoryRegistry */
    private $classFactoryRegistry;
    /** @var ValueFactory */
    private $valueFactory;

    public function __construct(
        FactoryRegistry $classFactoryRegistry = null,
        FactoryRegistry $nonInstantiableTypeResolver = null,
        IScalarCaster $casterHelper = null
    ) {
        if ($classFactoryRegistry === null) {
            $classFactoryRegistry = FactoryRegistry::withNativePhpClassesAdded();
        }

        if ($nonInstantiableTypeResolver === null) {
            $nonInstantiableTypeResolver = new FactoryRegistry();
        }
        if ($casterHelper === null) {
            $casterHelper = new ScalarCaster();
        }

        $this->classFactoryRegistry = $classFactoryRegistry;
        $this->valueFactory = new ValueFactory($casterHelper, $classFactoryRegistry, $nonInstantiableTypeResolver);
    }

    public function __invoke(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void {
        // If the type we are mapping has a last minute factory use it.
        if ($this->classFactoryRegistry->hasFactory($object->getName())) {
            $result = $this->classFactoryRegistry->create($object->getName(), $json);

            $object->setObject($result);
            return;
        }

        $values = (array) $json;
        foreach ($values as $key => $value) {
            if (! $propertyMap->hasProperty($key)) {
                continue;
            }

            $property = $propertyMap->getProperty($key);

            if (! $property->isNullable() && \is_null($value)) {
                throw new \RuntimeException(
                    "Null provided in json where {$object->getName()}::{$key} doesn't allow null value"
                );
            }

            if ($property->isNullable() && \is_null($value)) {
                $this->setValue($object, $property, null);
                continue;
            }

            $value = $this->valueFactory->build($mapper, $property, $value);
            $this->setValue($object, $property, $value);
        }
    }

    /**
     * @param mixed $value
     */
    private function setValue(ObjectWrapper $object, Property $propertyInfo, $value): void
    {
        if ($propertyInfo->getVisibility()->equals(Visibility::PUBLIC())) {
            $object->getObject()->{$propertyInfo->getName()} = $value;
            return;
        }

        $methodName = 'set' . \ucfirst($propertyInfo->getName());
        if (\method_exists($object->getObject(), $methodName)) {
            $method = new \ReflectionMethod($object->getObject(), $methodName);
            $parameters = $method->getParameters();

            if (\is_array($value) && \count($parameters) === 1 && $parameters[0]->isVariadic()) {
                $object->getObject()->$methodName(...$value);
                return;
            }

            $object->getObject()->$methodName($value);
            return;
        }

        throw new \RuntimeException(
            "{$object->getName()}::{$propertyInfo->getName()} is non-public and no setter method was found"
        );
    }
}
