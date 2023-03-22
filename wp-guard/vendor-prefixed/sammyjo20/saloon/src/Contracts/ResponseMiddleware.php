<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

interface ResponseMiddleware
{
    /**
     * Register a response middleware
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response|void
     */
    public function __invoke(Response $response);
}
