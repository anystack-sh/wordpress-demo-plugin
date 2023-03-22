<?php

/*
 * This file is part of the JsonSchema package.
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\JsonSchema;

/**
 * @package JsonSchema
 */
interface UriResolverInterface
{
    /**
     * Resolves a URI
     *
     * @param string      $uri     Absolute or relative
     * @param null|string $baseUri Optional base URI
     *
     * @return string Absolute URI
     */
    public function resolve($uri, $baseUri = null);
}
