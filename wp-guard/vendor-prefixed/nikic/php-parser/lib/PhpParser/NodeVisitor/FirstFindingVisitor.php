<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\NodeVisitor;

use Anystack\WPGuard\V001\PhpParser\Node;
use Anystack\WPGuard\V001\PhpParser\NodeTraverser;
use Anystack\WPGuard\V001\PhpParser\NodeVisitorAbstract;

/**
 * This visitor can be used to find the first node satisfying some criterion determined by
 * a filter callback.
 */
class FirstFindingVisitor extends NodeVisitorAbstract
{
    /** @var callable Filter callback */
    protected $filterCallback;
    /** @var null|Node Found node */
    protected $foundNode;

    public function __construct(callable $filterCallback) {
        $this->filterCallback = $filterCallback;
    }

    /**
     * Get found node satisfying the filter callback.
     *
     * Returns null if no node satisfies the filter callback.
     *
     * @return null|Node Found node (or null if not found)
     */
    public function getFoundNode() {
        return $this->foundNode;
    }

    public function beforeTraverse(array $nodes) {
        $this->foundNode = null;

        return null;
    }

    public function enterNode(Node $node) {
        $filterCallback = $this->filterCallback;
        if ($filterCallback($node)) {
            $this->foundNode = $node;
            return NodeTraverser::STOP_TRAVERSAL;
        }

        return null;
    }
}
