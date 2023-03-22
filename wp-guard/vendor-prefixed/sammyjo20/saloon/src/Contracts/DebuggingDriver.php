<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

use Anystack\WPGuard\V001\Saloon\Debugging\DebugData;

interface DebuggingDriver
{
    /**
     * Define the debugger name
     *
     * @return string
     */
    public function name(): string;

    /**
     * Determines if the debugging driver can be used
     *
     * E.g if it has the correct dependencies
     *
     * @return bool
     */
    public function hasDependencies(): bool;

    /**
     * Send the data to the debugger
     *
     * @param \Anystack\WPGuard\V001\Saloon\Debugging\DebugData $data
     *
     * @return void
     */
    public function send(DebugData $data): void;
}
