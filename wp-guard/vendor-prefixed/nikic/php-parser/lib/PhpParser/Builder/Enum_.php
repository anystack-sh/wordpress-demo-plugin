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
use Anystack\WPGuard\V001\PhpParser\Node;
use Anystack\WPGuard\V001\PhpParser\Node\Identifier;
use Anystack\WPGuard\V001\PhpParser\Node\Name;
use Anystack\WPGuard\V001\PhpParser\Node\Stmt;

class Enum_ extends Declaration
{
    protected $name;
    protected $scalarType = null;

    protected $implements = [];

    protected $uses = [];
    protected $enumCases = [];
    protected $constants = [];
    protected $methods = [];

    /** @var Node\AttributeGroup[] */
    protected $attributeGroups = [];

    /**
     * Creates an enum builder.
     *
     * @param string $name Name of the enum
     */
    public function __construct(string $name) {
        $this->name = $name;
    }

    /**
     * Sets the scalar type.
     *
     * @param string|Identifier $type
     *
     * @return $this
     */
    public function setScalarType($scalarType) {
        $this->scalarType = BuilderHelpers::normalizeType($scalarType);

        return $this;
    }

    /**
     * Implements one or more interfaces.
     *
     * @param Name|string ...$interfaces Names of interfaces to implement
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function implement(...$interfaces) {
        foreach ($interfaces as $interface) {
            $this->implements[] = BuilderHelpers::normalizeName($interface);
        }

        return $this;
    }

    /**
     * Adds a statement.
     *
     * @param Stmt|Anystack\WPGuard\V001\PhpParser\Builder $stmt The statement to add
     *
     * @return $this The builder instance (for fluid interface)
     */
    public function addStmt($stmt) {
        $stmt = BuilderHelpers::normalizeNode($stmt);

        $targets = [
            Stmt\TraitUse::class    => &$this->uses,
            Stmt\EnumCase::class    => &$this->enumCases,
            Stmt\ClassConst::class  => &$this->constants,
            Stmt\ClassMethod::class => &$this->methods,
        ];

        $class = \get_class($stmt);
        if (!isset($targets[$class])) {
            throw new \LogicException(sprintf('Unexpected node of type "%s"', $stmt->getType()));
        }

        $targets[$class][] = $stmt;

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
     * Returns the built class node.
     *
     * @return Stmt\Enum_ The built enum node
     */
    public function getNode() : Anystack\WPGuard\V001\PhpParser\Node {
        return new Stmt\Enum_($this->name, [
            'scalarType' => $this->scalarType,
            'implements' => $this->implements,
            'stmts' => array_merge($this->uses, $this->enumCases, $this->constants, $this->methods),
            'attrGroups' => $this->attributeGroups,
        ], $this->attributes);
    }
}
