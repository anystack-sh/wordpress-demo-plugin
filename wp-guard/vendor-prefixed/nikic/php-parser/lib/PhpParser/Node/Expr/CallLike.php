<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Node\Expr;

use Anystack\WPGuard\V001\PhpParser\Node\Arg;
use Anystack\WPGuard\V001\PhpParser\Node\Expr;
use Anystack\WPGuard\V001\PhpParser\Node\VariadicPlaceholder;

abstract class CallLike extends Expr {
    /**
     * Return raw arguments, which may be actual Args, or VariadicPlaceholders for first-class
     * callables.
     *
     * @return array<Arg|VariadicPlaceholder>
     */
    abstract public function getRawArgs(): array;

    /**
     * Returns whether this call expression is actually a first class callable.
     */
    public function isFirstClassCallable(): bool {
        foreach ($this->getRawArgs() as $arg) {
            if ($arg instanceof VariadicPlaceholder) {
                return true;
            }
        }
        return false;
    }

    /**
     * Assert that this is not a first-class callable and return only ordinary Args.
     *
     * @return Arg[]
     */
    public function getArgs(): array {
        assert(!$this->isFirstClassCallable());
        return $this->getRawArgs();
    }
}