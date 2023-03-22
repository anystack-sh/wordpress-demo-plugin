<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Middleware\Constructor;

use Anystack\WPGuard\V001\JsonMapper\Builders\PropertyBuilder;
use Anystack\WPGuard\V001\JsonMapper\Enums\Visibility;
use Anystack\WPGuard\V001\JsonMapper\Handler\FactoryRegistry;
use Anystack\WPGuard\V001\JsonMapper\Handler\ValueFactory;
use Anystack\WPGuard\V001\JsonMapper\Helpers\DocBlockHelper;
use Anystack\WPGuard\V001\JsonMapper\Helpers\IScalarCaster;
use Anystack\WPGuard\V001\JsonMapper\Helpers\NamespaceHelper;
use Anystack\WPGuard\V001\JsonMapper\Helpers\UseStatementHelper;
use Anystack\WPGuard\V001\JsonMapper\JsonMapperInterface;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\AnnotationMap;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\ArrayInformation;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyMap;
use ReflectionMethod;

class DefaultFactory
{
    /** @var string */
    private $objectName;
    /** @var JsonMapperInterface */
    private $mapper;
    /** @var PropertyMap */
    private $propertyMap;
    /** @var ValueFactory */
    private $valueFactory;
    /** @var array<int, string> */
    private $parameterMap = [];
    /** @var array<string, mixed> */
    private $parameterDefaults = [];

    public function __construct(
        string $objectName,
        ReflectionMethod $reflectedConstructor,
        JsonMapperInterface $mapper,
        IScalarCaster $scalarCaster,
        FactoryRegistry $classFactoryRegistry,
        FactoryRegistry $nonInstantiableTypeResolver = null
    ) {
        $this->objectName = $objectName;
        $this->mapper = $mapper;
        if ($nonInstantiableTypeResolver === null) {
            $nonInstantiableTypeResolver = new FactoryRegistry();
        }
        $this->propertyMap = new PropertyMap();
        $this->valueFactory = new ValueFactory($scalarCaster, $classFactoryRegistry, $nonInstantiableTypeResolver);

        $annotationMap = $this->getAnnotationMap($reflectedConstructor);
        $imports = UseStatementHelper::getImports($reflectedConstructor->getDeclaringClass());

        foreach ($reflectedConstructor->getParameters() as $param) {
            $builder = PropertyBuilder::new()
                ->setName($param->getName())
                ->setVisibility(Visibility::PUBLIC())
                ->setIsNullable($param->allowsNull());

            $type = 'mixed';
            $reflectedType = $param->getType();
            if (! \is_null($reflectedType)) {
                $type = $reflectedType->getName();
                if ($type === 'array') {
                    $builder->addType('mixed', ArrayInformation::singleDimension());
                } else {
                    $builder->addType($type, ArrayInformation::notAnArray());
                }
            }

            if ($annotationMap->hasParam($param->getName())) {
                $type = $annotationMap->getParam($param->getName());
                $types = \explode('|', $type);
                $types = \array_filter($types, static function (string $type) {
                    return $type !== 'null';
                });

                foreach ($types as $type) {
                    $type = \trim($type);
                    $isAnArrayType = \substr($type, -2) === '[]';

                    if (! $isAnArrayType) {
                        $builder->addType($type, ArrayInformation::notAnArray());
                        continue;
                    }

                    $initialBracketPosition = strpos($type, '[');
                    $dimensions = substr_count($type, '[]');

                    if ($initialBracketPosition !== false) {
                        $type = substr($type, 0, $initialBracketPosition);
                    }

                    $type = NamespaceHelper::resolveNamespace(
                        $type,
                        $reflectedConstructor->getDeclaringClass()->getNamespaceName(),
                        $imports
                    );

                    $builder->addType($type, ArrayInformation::multiDimension($dimensions));
                }
            }

            if (!$builder->hasAnyType()) {
                $builder->addType('mixed', ArrayInformation::notAnArray());
            }

            $this->propertyMap->addProperty($builder->build());
            $this->parameterMap[$param->getPosition()] = $param->getName();
            $this->parameterDefaults[$param->getName()] = $param->isDefaultValueAvailable() ? $param->getDefaultValue() : null;
        }

        ksort($this->parameterMap);
    }

    public function __invoke(\stdClass $json)
    {
        $values = [];

        foreach ($this->parameterMap as $position => $name) {
            $values[$position] = $this->valueFactory->build(
                $this->mapper,
                $this->propertyMap->getProperty($name),
                $json->$name ?? $this->parameterDefaults[$name]
            );
        }

        return new $this->objectName(...$values);
    }

    private function getAnnotationMap(ReflectionMethod $reflectedConstructor): AnnotationMap
    {
        $docBlock = $reflectedConstructor->getDocComment();
        $annotationMap = new AnnotationMap();
        if ($docBlock) {
            $annotationMap = DocBlockHelper::parseDocBlockToAnnotationMap($docBlock);
        }
        return $annotationMap;
    }
}
