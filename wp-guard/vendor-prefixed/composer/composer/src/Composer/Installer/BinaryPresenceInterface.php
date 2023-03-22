<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anystack\WPGuard\V001\Composer\Installer;

use Anystack\WPGuard\V001\Composer\Package\PackageInterface;

/**
 * Interface for the package installation manager that handle binary installation.
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
interface BinaryPresenceInterface
{
    /**
     * Make sure binaries are installed for a given package.
     *
     * @param PackageInterface $package package instance
     *
     * @return void
     */
    public function ensureBinariesPresence(PackageInterface $package);
}
