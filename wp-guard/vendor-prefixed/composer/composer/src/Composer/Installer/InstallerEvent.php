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

use Anystack\WPGuard\V001\Composer\Composer;
use Anystack\WPGuard\V001\Composer\DependencyResolver\Transaction;
use Anystack\WPGuard\V001\Composer\EventDispatcher\Event;
use Anystack\WPGuard\V001\Composer\IO\IOInterface;

class InstallerEvent extends Event
{
    /**
     * @var Composer
     */
    private $composer;

    /**
     * @var IOInterface
     */
    private $io;

    /**
     * @var bool
     */
    private $devMode;

    /**
     * @var bool
     */
    private $executeOperations;

    /**
     * @var Transaction
     */
    private $transaction;

    /**
     * Constructor.
     */
    public function __construct(string $eventName, Composer $composer, IOInterface $io, bool $devMode, bool $executeOperations, Transaction $transaction)
    {
        parent::__construct($eventName);

        $this->composer = $composer;
        $this->io = $io;
        $this->devMode = $devMode;
        $this->executeOperations = $executeOperations;
        $this->transaction = $transaction;
    }

    public function getComposer(): Composer
    {
        return $this->composer;
    }

    public function getIO(): IOInterface
    {
        return $this->io;
    }

    public function isDevMode(): bool
    {
        return $this->devMode;
    }

    public function isExecutingOperations(): bool
    {
        return $this->executeOperations;
    }

    public function getTransaction(): ?Transaction
    {
        return $this->transaction;
    }
}
