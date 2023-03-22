<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anystack\WPGuard\V001\Composer\PHPStan;

use Anystack\WPGuard\V001\Composer\DependencyResolver\Rule;
use Anystack\WPGuard\V001\Composer\Package\BasePackage;
use Anystack\WPGuard\V001\Composer\Package\Link;
use Anystack\WPGuard\V001\Composer\Semver\Constraint\ConstraintInterface;
use Anystack\WPGuard\V001\PhpParser\Node\Expr\MethodCall;
use PHPStan\Analyser\Scope;
use PHPStan\Reflection\MethodReflection;
use PHPStan\Type\Accessory\AccessoryNonEmptyStringType;
use PHPStan\Type\Constant\ConstantArrayType;
use PHPStan\Type\Constant\ConstantStringType;
use PHPStan\Type\Constant\ConstantIntegerType;
use PHPStan\Type\DynamicMethodReturnTypeExtension;
use PHPStan\Type\IntegerType;
use PHPStan\Type\StringType;
use PHPStan\Type\Type;
use PHPStan\Type\ObjectType;
use PHPStan\Type\TypeCombinator;
use Anystack\WPGuard\V001\PhpParser\Node\Identifier;

final class RuleReasonDataReturnTypeExtension implements DynamicMethodReturnTypeExtension
{
    public function getClass(): string
    {
        return Rule::class;
    }

    public function isMethodSupported(MethodReflection $methodReflection): bool
    {
        return strtolower($methodReflection->getName()) === 'getreasondata';
    }

    public function getTypeFromMethodCall(MethodReflection $methodReflection, MethodCall $methodCall, Scope $scope): Type
    {
        $reasonType = $scope->getType(new MethodCall($methodCall->var, new Identifier('getReason')));

        $types = [
            Rule::RULE_ROOT_REQUIRE => new ConstantArrayType([new ConstantStringType('packageName'), new ConstantStringType('constraint')], [new StringType, new ObjectType(ConstraintInterface::class)]),
            Rule::RULE_FIXED => new ConstantArrayType([new ConstantStringType('package')], [new ObjectType(BasePackage::class)]),
            Rule::RULE_PACKAGE_CONFLICT => new ObjectType(Link::class),
            Rule::RULE_PACKAGE_REQUIRES => new ObjectType(Link::class),
            Rule::RULE_PACKAGE_SAME_NAME => TypeCombinator::intersect(new StringType, new AccessoryNonEmptyStringType()),
            Rule::RULE_LEARNED => new IntegerType(),
            Rule::RULE_PACKAGE_ALIAS => new ObjectType(BasePackage::class),
            Rule::RULE_PACKAGE_INVERSE_ALIAS => new ObjectType(BasePackage::class),
        ];

        foreach ($types as $const => $type) {
            if ((new ConstantIntegerType($const))->isSuperTypeOf($reasonType)->yes()) {
                return $type;
            }
        }

        return TypeCombinator::union(...$types);
    }
}
