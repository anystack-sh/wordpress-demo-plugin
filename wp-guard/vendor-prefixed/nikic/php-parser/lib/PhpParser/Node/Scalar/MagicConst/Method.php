<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Scalar\MagicConst;

use Anystack\WPGuard\V001\PhpParser\Node\Scalar\MagicConst;

class Method extends MagicConst
{
    public function getName() : string {
        return '__METHOD__';
    }
    
    public function getType() : string {
        return 'Scalar_MagicConst_Method';
    }
}
