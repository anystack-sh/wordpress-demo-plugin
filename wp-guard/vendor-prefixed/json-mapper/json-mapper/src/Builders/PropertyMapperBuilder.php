<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Builders;

use Anystack\WPGuard\V001\JsonMapper\Handler\FactoryRegistry;
use Anystack\WPGuard\V001\JsonMapper\Handler\PropertyMapper;
use Anystack\WPGuard\V001\JsonMapper\Helpers\IScalarCaster;

class PropertyMapperBuilder
{
    /** @var FactoryRegistry|null */
    private $classFactoryRegistry;
    /** @var FactoryRegistry|null */
    private $nonInstantiableTypeResolver;
    /** @var IScalarCaster|null */
    private $scalarCaster;

    public static function new(): PropertyMapperBuilder
    {
        return new PropertyMapperBuilder();
    }

    public function build(): PropertyMapper
    {
        return new PropertyMapper($this->classFactoryRegistry, $this->nonInstantiableTypeResolver, $this->scalarCaster);
    }

    public function withClassFactoryRegistry(FactoryRegistry $classFactoryRegistry): PropertyMapperBuilder
    {
        $this->classFactoryRegistry = $classFactoryRegistry;

        return $this;
    }

    public function withNonInstantiableTypeResolver(FactoryRegistry $nonInstantiableTypeResolver): PropertyMapperBuilder
    {
        $this->nonInstantiableTypeResolver = $nonInstantiableTypeResolver;

        return $this;
    }

    public function withScalarCaster(IScalarCaster $scalarCaster): PropertyMapperBuilder
    {
        $this->scalarCaster = $scalarCaster;

        return $this;
    }
}
