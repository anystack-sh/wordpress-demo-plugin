<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Stmt;

use Anystack\WPGuard\V001\PhpParser\Node\Identifier;
use Anystack\WPGuard\V001\PhpParser\Node\Stmt;

class Goto_ extends Stmt
{
    /** @var Identifier Name of label to jump to */
    public $name;

    /**
     * Constructs a goto node.
     *
     * @param string|Identifier $name       Name of label to jump to
     * @param array             $attributes Additional attributes
     */
    public function __construct($name, array $attributes = []) {
        $this->attributes = $attributes;
        $this->name = \is_string($name) ? new Identifier($name) : $name;
    }

    public function getSubNodeNames() : array {
        return ['name'];
    }
    
    public function getType() : string {
        return 'Stmt_Goto';
    }
}
