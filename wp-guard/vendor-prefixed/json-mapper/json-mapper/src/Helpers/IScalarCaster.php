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

interface IScalarCaster
{
    /** @return string|bool|int|float */
    public function cast(ScalarType $scalarType, $value);
}
