<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Stmt;

use Anystack\WPGuard\V001\PhpParser\Node;

class Switch_ extends Node\Stmt
{
    /** @var Node\Expr Condition */
    public $cond;
    /** @var Case_[] Case list */
    public $cases;

    /**
     * Constructs a case node.
     *
     * @param Node\Expr $cond       Condition
     * @param Case_[]   $cases      Case list
     * @param array     $attributes Additional attributes
     */
    public function __construct(Node\Expr $cond, array $cases, array $attributes = []) {
        $this->attributes = $attributes;
        $this->cond = $cond;
        $this->cases = $cases;
    }

    public function getSubNodeNames() : array {
        return ['cond', 'cases'];
    }
    
    public function getType() : string {
        return 'Stmt_Switch';
    }
}
