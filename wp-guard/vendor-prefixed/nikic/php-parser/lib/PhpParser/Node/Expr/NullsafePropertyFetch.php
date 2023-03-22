<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Expr;

use Anystack\WPGuard\V001\PhpParser\Node\Expr;
use Anystack\WPGuard\V001\PhpParser\Node\Identifier;

class NullsafePropertyFetch extends Expr
{
    /** @var Expr Variable holding object */
    public $var;
    /** @var Identifier|Expr Property name */
    public $name;

    /**
     * Constructs a nullsafe property fetch node.
     *
     * @param Expr                   $var        Variable holding object
     * @param string|Identifier|Expr $name       Property name
     * @param array                  $attributes Additional attributes
     */
    public function __construct(Expr $var, $name, array $attributes = []) {
        $this->attributes = $attributes;
        $this->var = $var;
        $this->name = \is_string($name) ? new Identifier($name) : $name;
    }

    public function getSubNodeNames() : array {
        return ['var', 'name'];
    }
    
    public function getType() : string {
        return 'Expr_NullsafePropertyFetch';
    }
}
