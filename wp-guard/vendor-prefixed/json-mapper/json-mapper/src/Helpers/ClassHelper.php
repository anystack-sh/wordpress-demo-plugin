<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Helpers;

use Anystack\WPGuard\V001\JsonMapper\Enums\ScalarType;
use ReflectionClass;

class ClassHelper
{
    public static function isBuiltin(string $type): bool
    {
        if ($type === 'mixed' || ScalarType::isValid($type) || ! \class_exists($type)) {
            return false;
        }

        $reflection = new ReflectionClass($type);
        return $reflection->isInternal();
    }

    public static function isCustom(string $type): bool
    {
        if ($type === 'mixed' || ScalarType::isValid($type) || ! \class_exists($type)) {
            return false;
        }

        $reflection = new ReflectionClass($type);
        return !$reflection->isInternal();
    }
}
