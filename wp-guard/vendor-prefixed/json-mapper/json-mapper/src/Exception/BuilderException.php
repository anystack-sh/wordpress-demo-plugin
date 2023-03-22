<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Exception;

class BuilderException extends \Exception
{
    public static function invalidJsonMapperClassName(string $className): self
    {
        return new self("'$className' (or it parent classes) don't implement the JsonMapperInterface");
    }

    public static function forBuildingWithoutMiddleware(): self
    {
        return new self('Trying to build a JsonMapper instance without middleware');
    }
}
