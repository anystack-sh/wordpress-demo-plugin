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

namespace Anystack\WPGuard\V001\Symfony\Component\Cache\Marshaller;

use Anystack\WPGuard\V001\Symfony\Component\Cache\Exception\CacheException;

/**
 * Compresses values using gzdeflate().
 *
 * @author Nicolas Grekas <p@tchwork.com>
 */
class DeflateMarshaller implements MarshallerInterface
{
    private MarshallerInterface $marshaller;

    public function __construct(MarshallerInterface $marshaller)
    {
        if (!\function_exists('gzdeflate')) {
            throw new CacheException('The "zlib" PHP extension is not loaded.');
        }

        $this->marshaller = $marshaller;
    }

    public function marshall(array $values, ?array &$failed): array
    {
        return array_map('gzdeflate', $this->marshaller->marshall($values, $failed));
    }

    public function unmarshall(string $value): mixed
    {
        if (false !== $inflatedValue = @gzinflate($value)) {
            $value = $inflatedValue;
        }

        return $this->marshaller->unmarshall($value);
    }
}
