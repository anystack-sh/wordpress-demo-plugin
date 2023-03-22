<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

interface HasPagination
{
    /**
     * Create a paginator instance
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Request $request
     * @param mixed ...$additionalArguments
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Paginator
     */
    public function paginate(Request $request, mixed ...$additionalArguments): Paginator;
}
