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

interface Connector extends Authenticatable, CanThrowRequestExceptions, HasConfig, HasHeaders, HasQueryParams, HasDelay, HasMiddlewarePipeline, HasMockClient
{
    /**
     * \Handle the boot lifecycle hook
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function boot(PendingRequest $pendingRequest): void;

    /**
     * Cast the response to a DTO.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return mixed
     */
    public function createDtoFromResponse(Response $response): mixed;

    /**
     * Define the base URL of the API.
     *
     * @return string
     */
    public function resolveBaseUrl(): string;

    /**
     * Get the response class
     *
     * @return class-string<\Saloon\Contracts\Response>|null
     */
    public function resolveResponseClass(): ?string;

    /**
     * Create a request pool
     *
     * @template TKey of array-key
     *
     * @param iterable<\GuzzleHttp\Promise\PromiseInterface|\Anystack\WPGuard\V001\Saloon\Contracts\Request>|callable(\Anystack\WPGuard\V001\Saloon\Contracts\Connector): iterable<\GuzzleHttp\Promise\PromiseInterface|\Anystack\WPGuard\V001\Saloon\Contracts\Request> $requests
     * @param int|callable(int $pendingRequests): (int) $concurrency
     * @param callable(\Anystack\WPGuard\V001\Saloon\Contracts\Response, TKey $key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface $poolAggregate): (void)|null $responseHandler
     * @param callable(mixed $reason, TKey $key, \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface $poolAggregate): (void)|null $exceptionHandler
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Pool
     */
    public function pool(iterable|callable $requests = [], int|callable $concurrency = 5, callable|null $responseHandler = null, callable|null $exceptionHandler = null): Pool;

    /**
     * Manage the request sender.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Sender
     */
    public function sender(): Sender;

    /**
     * Send a request
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Request $request
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     */
    public function send(Request $request, MockClient $mockClient = null): Response;

    /**
     * Send a synchronous request and retry if it fails
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Request $request
     * @param int $maxAttempts
     * @param int $interval
     * @param callable(\Throwable, \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest): (bool)|null $handleRetry
     * @param bool $throw
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     */
    public function sendAndRetry(Request $request, int $maxAttempts, int $interval = 0, callable $handleRetry = null, bool $throw = false, MockClient $mockClient = null): Response;

    /**
     * Send a request asynchronously
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Request $request
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface
     */
    public function sendAsync(Request $request, MockClient $mockClient = null): PromiseInterface;

    /**
     * Create a new PendingRequest
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Request $request
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest
     */
    public function createPendingRequest(Request $request, MockClient $mockClient = null): PendingRequest;
}
