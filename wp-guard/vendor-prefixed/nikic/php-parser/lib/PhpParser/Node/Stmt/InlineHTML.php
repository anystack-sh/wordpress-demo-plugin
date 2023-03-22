<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Stmt;

use Anystack\WPGuard\V001\PhpParser\Node\Stmt;

class InlineHTML extends Stmt
{
    /** @var string String */
    public $value;

    /**
     * Constructs an inline HTML node.
     *
     * @param string $value      String
     * @param array  $attributes Additional attributes
     */
    public function __construct(string $value, array $attributes = []) {
        $this->attributes = $attributes;
        $this->value = $value;
    }

    public function getSubNodeNames() : array {
        return ['value'];
    }
    
    public function getType() : string {
        return 'Stmt_InlineHTML';
    }
}
