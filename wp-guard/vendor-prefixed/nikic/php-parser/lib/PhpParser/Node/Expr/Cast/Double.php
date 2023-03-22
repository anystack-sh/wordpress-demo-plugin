<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Expr\Cast;

use Anystack\WPGuard\V001\PhpParser\Node\Expr\Cast;

class Double extends Cast
{
    // For use in "kind" attribute
    const KIND_DOUBLE = 1; // "double" syntax
    const KIND_FLOAT = 2;  // "float" syntax
    const KIND_REAL = 3; // "real" syntax

    public function getType() : string {
        return 'Expr_Cast_Double';
    }
}
