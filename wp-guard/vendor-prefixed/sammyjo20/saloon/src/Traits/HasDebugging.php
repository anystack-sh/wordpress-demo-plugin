<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits;

use Anystack\WPGuard\V001\Saloon\Debugging\Debugger;

trait HasDebugging
{
    /**
     * Debugger
     *
     * @var \Anystack\WPGuard\V001\Saloon\Debugging\Debugger|null
     */
    protected ?Debugger $debugger = null;

    /**
     * Retrieve the debugger
     *
     * @param callable(\Anystack\WPGuard\V001\Saloon\Debugging\Debugger): (void)|null $callback
     * @return \Anystack\WPGuard\V001\Saloon\Debugging\Debugger
     */
    public function debug(?callable $callback = null): Debugger
    {
        $debugger = $this->debugger ??= new Debugger;

        if (is_callable($callback)) {
            $callback($debugger);
        }

        return $debugger;
    }
}
