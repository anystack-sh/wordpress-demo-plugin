<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\JsonMapper\Cache;

use Psr\SimpleCache\CacheInterface;
use Anystack\WPGuard\V001\Symfony\Component\Cache\Adapter\ArrayAdapter;
use Anystack\WPGuard\V001\Symfony\Component\Cache\Psr16Cache;

class ArrayCache extends Psr16Cache implements CacheInterface
{
    public function __construct()
    {
        parent::__construct(new ArrayAdapter());
    }
}
