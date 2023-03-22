<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Exception;

class ClassFactoryException extends \Exception
{
    public static function forDuplicateClassname(string $className): self
    {
        return new self("A factory for $className has already been registered");
    }

    public static function forMissingClassname(string $className): self
    {
        return new self("A factory for $className has not been registered");
    }
}
