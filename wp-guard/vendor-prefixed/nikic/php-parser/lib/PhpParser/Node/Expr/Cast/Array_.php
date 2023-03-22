<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Expr\Cast;

use Anystack\WPGuard\V001\PhpParser\Node\Expr\Cast;

class Array_ extends Cast
{
    public function getType() : string {
        return 'Expr_Cast_Array';
    }
}
