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

namespace Anystack\WPGuard\V001\Symfony\Component\Cache\Adapter;

use Anystack\WPGuard\V001\Symfony\Contracts\Cache\TagAwareCacheInterface;

/**
 * @author Robin Chalas <robin.chalas@gmail.com>
 */
class TraceableTagAwareAdapter extends TraceableAdapter implements TagAwareAdapterInterface, TagAwareCacheInterface
{
    public function __construct(TagAwareAdapterInterface $pool)
    {
        parent::__construct($pool);
    }

    public function invalidateTags(array $tags): bool
    {
        $event = $this->start(__FUNCTION__);
        try {
            return $event->result = $this->pool->invalidateTags($tags);
        } finally {
            $event->end = microtime(true);
        }
    }
}
