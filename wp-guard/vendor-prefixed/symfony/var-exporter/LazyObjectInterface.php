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

namespace Anystack\WPGuard\V001\Symfony\Component\VarExporter;

interface LazyObjectInterface
{
    /**
     * Returns whether the object is initialized.
     *
     * @param $partial Whether partially initialized objects should be considered as initialized
     */
    public function isLazyObjectInitialized(bool $partial = false): bool;

    /**
     * Forces initialization of a lazy object and returns it.
     */
    public function initializeLazyObject(): object;

    /**
     * @return bool Returns false when the object cannot be reset, ie when it's not a lazy object
     */
    public function resetLazyObject(): bool;
}
