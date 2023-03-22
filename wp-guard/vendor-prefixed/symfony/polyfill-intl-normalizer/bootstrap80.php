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

use Anystack\WPGuard\V001\Symfony\Polyfill\Intl\Normalizer as p;

if (!function_exists('normalizer_is_normalized')) {
    function normalizer_is_normalized(?string $string, ?int $form = p\Normalizer::FORM_C): bool { return p\Normalizer::isNormalized((string) $string, (int) $form); }
}
if (!function_exists('normalizer_normalize')) {
    function normalizer_normalize(?string $string, ?int $form = p\Normalizer::FORM_C): string|false { return p\Normalizer::normalize((string) $string, (int) $form); }
}
