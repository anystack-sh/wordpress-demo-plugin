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

interface Pool
{
    /**
     * Specify a callback to happen for each successful request
     *
     * @param callable(\Anystack\WPGuard\V001\Saloon\Contracts\Response, array-key $key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface $poolAggregate): (void) $callable
     * @return $this
     */
    public function withResponseHandler(callable $callable): static;

    /**
     * Specify a callback to happen for each failed request
     *
     * @param callable(mixed $reason, array-key $key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface $poolAggregate): (void) $callable
     * @return $this
     */
    public function withExceptionHandler(callable $callable): static;

    /**
     * Set the amount of concurrent requests that should be sent
     *
     * @param int|callable(int $pendingRequests): (int) $concurrency
     * @return $this
     */
    public function setConcurrency(int|callable $concurrency): static;

    /**
     * Set the requests
     *
     * @param iterable<array-key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface|\Anystack\WPGuard\V001\Saloon\Contracts\Request>|callable(\Anystack\WPGuard\V001\Saloon\Contracts\Connector): (iterable<array-key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface|\Anystack\WPGuard\V001\Saloon\Contracts\Request>) $requests
     * @return $this
     */
    public function setRequests(iterable|callable $requests): static;

    /**
     * Get the request generator
     *
     * @return iterable<array-key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface|\Anystack\WPGuard\V001\Saloon\Contracts\Request>
     */
    public function getRequests(): iterable;

    /**
     * Send the pool and create a Promise
     *
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface
     */
    public function send(): PromiseInterface;
}
