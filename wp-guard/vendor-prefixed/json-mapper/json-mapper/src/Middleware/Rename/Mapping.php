<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Middleware\Rename;

class Mapping
{
    /** @var string */
    private $class;
    /** @var string */
    private $from;
    /** @var string */
    private $to;

    public function __construct(string $class, string $from, string $to)
    {
        $this->class = $class;
        $this->from = $from;
        $this->to = $to;
    }

    public function getClass(): string
    {
        return $this->class;
    }

    public function getFrom(): string
    {
        return $this->from;
    }

    public function getTo(): string
    {
        return $this->to;
    }
}
