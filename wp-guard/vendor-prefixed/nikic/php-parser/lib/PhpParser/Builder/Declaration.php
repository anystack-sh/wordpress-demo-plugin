<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Builder;

use Anystack\WPGuard\V001\PhpParser;
use Anystack\WPGuard\V001\PhpParser\BuilderHelpers;

abstract class Declaration implements Anystack\WPGuard\V001\PhpParser\Builder
{
    protected $attributes = [];

    abstract public function addStmt($stmt);

    /**
     * Adds multiple statements.
     *
     * @param array $stmts The statements to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmts(array $stmts) {
        foreach ($stmts as $stmt) {
            $this->addStmt($stmt);
        }

        return $this;
    }

    /**
     * Sets doc comment for the declaration.
     *
     * @param Anystack\WPGuard\V001\PhpParser\Comment\Doc|string $docComment Doc comment to set
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDocComment($docComment) {
        $this->attributes['comments'] = [
            BuilderHelpers::normalizeDocComment($docComment)
        ];

        return $this;
    }
}
