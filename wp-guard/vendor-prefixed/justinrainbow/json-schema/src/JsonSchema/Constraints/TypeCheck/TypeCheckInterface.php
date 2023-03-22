<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\JsonSchema\Constraints\TypeCheck;

interface TypeCheckInterface
{
    public static function isObject($value);

    public static function isArray($value);

    public static function propertyGet($value, $property);

    public static function propertySet(&$value, $property, $data);

    public static function propertyExists($value, $property);

    public static function propertyCount($value);
}
