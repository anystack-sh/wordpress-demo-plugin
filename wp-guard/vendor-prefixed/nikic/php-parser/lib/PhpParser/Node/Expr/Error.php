<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Expr;

use Anystack\WPGuard\V001\PhpParser\Node\Expr;

/**
 * Error node used during parsing with error recovery.
 *
 * An error node may be placed at a position where an expression is required, but an error occurred.
 * Error nodes will not be present if the parser is run in throwOnError mode (the default).
 */
class Error extends Expr
{
    /**
     * Constructs an error node.
     *
     * @param array $attributes Additional attributes
     */
    public function __construct(array $attributes = []) {
        $this->attributes = $attributes;
    }

    public function getSubNodeNames() : array {
        return [];
    }
    
    public function getType() : string {
        return 'Expr_Error';
    }
}
