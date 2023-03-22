<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Expr;

use Anystack\WPGuard\V001\PhpParser\Node\Expr;

class Variable extends Expr
{
    /** @var string|Expr Name */
    public $name;

    /**
     * Constructs a variable node.
     *
     * @param string|Expr $name       Name
     * @param array       $attributes Additional attributes
     */
    public function __construct($name, array $attributes = []) {
        $this->attributes = $attributes;
        $this->name = $name;
    }

    public function getSubNodeNames() : array {
        return ['name'];
    }
    
    public function getType() : string {
        return 'Expr_Variable';
    }
}
