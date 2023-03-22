<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

use Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface;

interface Dispatcher
{
    /**
     * Execute the action
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response|\Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface
     */
    public function execute(): Response|PromiseInterface;
}
