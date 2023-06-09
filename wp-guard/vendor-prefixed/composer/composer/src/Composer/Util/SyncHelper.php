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

namespace Anystack\WPGuard\V001\Composer\Util;

use Anystack\WPGuard\V001\Composer\Downloader\DownloaderInterface;
use Anystack\WPGuard\V001\Composer\Package\PackageInterface;
use Anystack\WPGuard\V001\React\Promise\PromiseInterface;

class SyncHelper
{
    /**
     * Helps you download + install a single package in a synchronous way
     *
     * This executes all the required steps and waits for promises to complete
     *
     * @param Loop                  $loop        Loop instance which you can get from $composer->getLoop()
     * @param DownloaderInterface   $downloader  Downloader instance you can get from $composer->getDownloadManager()->getDownloader('zip') for example
     * @param string                $path        the installation path for the package
     * @param PackageInterface      $package     the package to install
     * @param PackageInterface|null $prevPackage the previous package if this is an update and not an initial installation
     */
    public static function downloadAndInstallPackageSync(Loop $loop, DownloaderInterface $downloader, string $path, PackageInterface $package, ?PackageInterface $prevPackage = null): void
    {
        $type = $prevPackage ? 'update' : 'install';

        try {
            self::await($loop, $downloader->download($package, $path, $prevPackage));

            self::await($loop, $downloader->prepare($type, $package, $path, $prevPackage));

            if ($type === 'update') {
                self::await($loop, $downloader->update($package, $prevPackage, $path));
            } else {
                self::await($loop, $downloader->install($package, $path));
            }
        } catch (\Exception $e) {
            self::await($loop, $downloader->cleanup($type, $package, $path, $prevPackage));
            throw $e;
        }

        self::await($loop, $downloader->cleanup($type, $package, $path, $prevPackage));
    }

    /**
     * Waits for a promise to resolve
     *
     * @param Loop                  $loop    Loop instance which you can get from $composer->getLoop()
     */
    public static function await(Loop $loop, ?PromiseInterface $promise = null): void
    {
        if ($promise) {
            $loop->wait([$promise]);
        }
    }
}
