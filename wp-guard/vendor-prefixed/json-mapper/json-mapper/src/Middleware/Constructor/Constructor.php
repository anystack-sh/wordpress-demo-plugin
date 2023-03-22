<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Middleware\Constructor;

use Anystack\WPGuard\V001\JsonMapper\Handler\FactoryRegistry;
use Anystack\WPGuard\V001\JsonMapper\Helpers\ScalarCaster;
use Anystack\WPGuard\V001\JsonMapper\JsonMapperInterface;
use Anystack\WPGuard\V001\JsonMapper\Middleware\AbstractMiddleware;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyMap;
use Anystack\WPGuard\V001\JsonMapper\Wrapper\ObjectWrapper;

class Constructor extends AbstractMiddleware
{
    /** @var FactoryRegistry */
    private $factoryRegistry;

    public function __construct(FactoryRegistry $factoryRegistry)
    {
        $this->factoryRegistry = $factoryRegistry;
    }

    public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void {
        if ($this->factoryRegistry->hasFactory($object->getName())) {
            return;
        }

        $reflectedConstructor = $object->getReflectedObject()->getConstructor();
        if (\is_null($reflectedConstructor) || $reflectedConstructor->getNumberOfParameters() === 0) {
            return;
        }

        $this->factoryRegistry->addFactory(
            $object->getName(),
            new DefaultFactory(
                $object->getName(),
                $reflectedConstructor,
                $mapper,
                new ScalarCaster(), // @TODO Copy current caster ??
                $this->factoryRegistry
            )
        );
    }
}
