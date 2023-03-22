<?php

/*
 * This file is part of the Symfony package.
 *
 * (c) Fabien Potencier <fabien@symfony.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Symfony\Component\Console\Helper;

/**
 * @internal
 */
class TableRows implements \IteratorAggregate
{
    private $generator;

    public function __construct(\Closure $generator)
    {
        $this->generator = $generator;
    }

    public function getIterator(): \Traversable
    {
        return ($this->generator)();
    }
}
