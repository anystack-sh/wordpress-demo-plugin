<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Expr\BinaryOp;

use Anystack\WPGuard\V001\PhpParser\Node\Expr\BinaryOp;

class BooleanOr extends BinaryOp
{
    public function getOperatorSigil() : string {
        return '||';
    }
    
    public function getType() : string {
        return 'Expr_BinaryOp_BooleanOr';
    }
}
