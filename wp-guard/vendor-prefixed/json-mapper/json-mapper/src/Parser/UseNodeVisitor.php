<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Parser;

use Anystack\WPGuard\V001\PhpParser\Node;
use Anystack\WPGuard\V001\PhpParser\NodeVisitorAbstract;
use Anystack\WPGuard\V001\PhpParser\Node\Stmt;

class UseNodeVisitor extends NodeVisitorAbstract
{
    /** @var Import[] */
    private $imports = [];

    /**
     * @return null
     */
    public function enterNode(Node $node)
    {
        if ($node instanceof Stmt\Use_) {
            foreach ($node->uses as $use) {
                $this->imports[] = new Import($use->name->toString(), \is_null($use->alias) ? null : $use->alias->name);
            }
        } elseif ($node instanceof Stmt\GroupUse) {
            foreach ($node->uses as $use) {
                $this->imports[] = new Import(
                    "{$node->prefix}\\{$use->name}",
                    \is_null($use->alias) ? null : $use->alias->name
                );
            }
        }

        return null;
    }

    /** @return Import[] */
    public function getImports(): array
    {
        return $this->imports;
    }
}
