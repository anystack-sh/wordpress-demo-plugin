<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits;

use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;

trait Bootable
{
    /**
     * Handle the boot lifecycle hook
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function boot(PendingRequest $pendingRequest): void
    {
        //
    }
}
