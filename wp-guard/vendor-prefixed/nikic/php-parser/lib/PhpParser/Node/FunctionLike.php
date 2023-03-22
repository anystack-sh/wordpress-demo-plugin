<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node;

use Anystack\WPGuard\V001\PhpParser\Node;

interface FunctionLike extends Node
{
    /**
     * Whether to return by reference
     *
     * @return bool
     */
    public function returnsByRef() : bool;

    /**
     * List of parameters
     *
     * @return Param[]
     */
    public function getParams() : array;

    /**
     * Get the declared return type or null
     *
     * @return null|Identifier|Name|ComplexType
     */
    public function getReturnType();

    /**
     * The function body
     *
     * @return Stmt[]|null
     */
    public function getStmts();

    /**
     * Get PHP attribute groups.
     *
     * @return AttributeGroup[]
     */
    public function getAttrGroups() : array;
}
