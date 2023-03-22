<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

use Anystack\WPGuard\V001\Saloon\Debugging\Debugger;

interface HasDebugging
{
    /**
     * Retrieve the debugger
     *
     * @param callable(\Anystack\WPGuard\V001\Saloon\Debugging\Debugger): (void)|null $callback
     * @return \Anystack\WPGuard\V001\Saloon\Debugging\Debugger
     */
    public function debug(?callable $callback = null): Debugger;
}
