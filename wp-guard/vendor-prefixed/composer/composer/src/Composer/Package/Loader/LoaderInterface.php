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

namespace Anystack\WPGuard\V001\Composer\Package\Loader;

use Anystack\WPGuard\V001\Composer\Package\CompletePackage;
use Anystack\WPGuard\V001\Composer\Package\CompleteAliasPackage;
use Anystack\WPGuard\V001\Composer\Package\RootAliasPackage;
use Anystack\WPGuard\V001\Composer\Package\RootPackage;
use Anystack\WPGuard\V001\Composer\Package\BasePackage;

/**
 * Defines a loader that takes an array to create package instances
 *
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
interface LoaderInterface
{
    /**
     * Converts a package from an array to a real instance
     *
     * @param  mixed[] $config package data
     * @param  string  $class  FQCN to be instantiated
     *
     * @return CompletePackage|CompleteAliasPackage|RootPackage|RootAliasPackage
     *
     * @phpstan-param class-string<CompletePackage|RootPackage> $class
     */
    public function load(array $config, string $class = 'Anystack\WPGuard\V001\Composer\Package\CompletePackage'): BasePackage;
}
