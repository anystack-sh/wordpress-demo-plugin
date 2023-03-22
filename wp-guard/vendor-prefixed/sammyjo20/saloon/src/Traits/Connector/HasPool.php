<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Connector;

use Anystack\WPGuard\V001\Saloon\Http\Pool;
use Anystack\WPGuard\V001\Saloon\Contracts\Pool as PoolContract;

trait HasPool
{
    /**
     * Create a request pool
     *
     * @param iterable<\GuzzleHttp\Promise\PromiseInterface|\Anystack\WPGuard\V001\Saloon\Contracts\Request>|callable(\Anystack\WPGuard\V001\Saloon\Contracts\Connector): iterable<\GuzzleHttp\Promise\PromiseInterface|\Anystack\WPGuard\V001\Saloon\Contracts\Request> $requests
     * @param int|callable(int $pendingRequests): (int) $concurrency
     * @param callable(\Anystack\WPGuard\V001\Saloon\Contracts\Response, array-key $key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface $poolAggregate): (void)|null $responseHandler
     * @param callable(mixed $reason, array-key $key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface $poolAggregate): (void)|null $exceptionHandler
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Pool
     */
    public function pool(iterable|callable $requests = [], int|callable $concurrency = 5, callable|null $responseHandler = null, callable|null $exceptionHandler = null): PoolContract
    {
        return new Pool($this, $requests, $concurrency, $responseHandler, $exceptionHandler);
    }
}
