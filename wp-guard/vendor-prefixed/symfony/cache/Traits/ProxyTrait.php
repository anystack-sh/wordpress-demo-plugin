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

namespace Anystack\WPGuard\V001\Symfony\Component\Cache\Traits;

use Anystack\WPGuard\V001\Symfony\Component\Cache\PruneableInterface;
use Anystack\WPGuard\V001\Symfony\Contracts\Service\ResetInterface;

/**
 * @author Nicolas Grekas <p@tchwork.com>
 *
 * @internal
 */
trait ProxyTrait
{
    private object $pool;

    public function prune(): bool
    {
        return $this->pool instanceof PruneableInterface && $this->pool->prune();
    }

    public function reset()
    {
        if ($this->pool instanceof ResetInterface) {
            $this->pool->reset();
        }
    }
}
