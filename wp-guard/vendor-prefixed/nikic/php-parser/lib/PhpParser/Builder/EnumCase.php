<?php
/**
 * @license BSD-3-Clause
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\PhpParser\Builder;

use Anystack\WPGuard\V001\PhpParser;
use Anystack\WPGuard\V001\PhpParser\BuilderHelpers;
use Anystack\WPGuard\V001\PhpParser\Node;
use Anystack\WPGuard\V001\PhpParser\Node\Identifier;
use Anystack\WPGuard\V001\PhpParser\Node\Stmt;

class EnumCase implements Anystack\WPGuard\V001\PhpParser\Builder
{
    protected $name;
    protected $value = null;
    protected $attributes = [];

    /** @var Node\AttributeGroup[] */
    protected $attributeGroups = [];

    /**
     * Creates an enum case builder.
     *
     * @param string|Identifier $name  Name
     */
    public function __construct($name) {
        $this->name = $name;
    }

    /**
     * Sets the value.
     *
     * @param Node\Expr|string|int $value
     *
     * @return $this
     */
    public function setValue($value) {
        $this->value = BuilderHelpers::normalizeValue($value);

        return $this;
    }

    /**
     * Sets doc comment for the constant.
     *
     * @param Anystack\WPGuard\V001\PhpParser\Comment\Doc|string $docComment Doc comment to set
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function setDocComment($docComment) {
        $this->attributes = [
            'comments' => [BuilderHelpers::normalizeDocComment($docComment)]
        ];

        return $this;
    }

    /**
     * Adds an attribute group.
     *
     * @param Node\Attribute|Node\AttributeGroup $attribute
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addAttribute($attribute) {
        $this->attributeGroups[] = BuilderHelpers::normalizeAttribute($attribute);

        return $this;
    }

    /**
     * Returns the built enum case node.
     *
     * @return Stmt\EnumCase The built constant node
     */
    public function getNode(): Anystack\WPGuard\V001\PhpParser\Node {
        return new Stmt\EnumCase(
            $this->name,
            $this->value,
            $this->attributeGroups,
            $this->attributes
        );
    }
}
