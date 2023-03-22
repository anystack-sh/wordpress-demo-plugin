<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Debugging\Drivers;

use Anystack\WPGuard\V001\Saloon\Debugging\DebugData;

class ErrorLogDebugger extends DebuggingDriver
{
    /**
     * Define the name
     *
     * @return string
     */
    public function name(): string
    {
        return 'error_log';
    }

    /**
     * Check if the debugging driver can be used
     *
     * @return bool
     */
    public function hasDependencies(): bool
    {
        return true;
    }

    /**
     * @param \Anystack\WPGuard\V001\Saloon\Debugging\DebugData $data
     *
     * @return void
     * @throws \ANYSTACK_WP_GUARD_JsonException
     */
    public function send(DebugData $data): void
    {
        $encoded = json_encode($this->formatData($data), JSON_THROW_ON_ERROR);

        error_log($encoded, LOG_DEBUG);
    }
}
