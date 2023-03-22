<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

interface MiddlewarePipeline
{
    /**
     * Add a middleware before the request is sent
     *
     * @param callable(\Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest): (\Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest|\Anystack\WPGuard\V001\Saloon\Contracts\SimulatedResponsePayload|void) $callable
     * @param bool $prepend
     * @param string|null $name
     * @return $this
     */
    public function onRequest(callable $callable, bool $prepend = false, ?string $name = null): static;

    /**
     * Add a middleware after the request is sent
     *
     * @param callable(\Anystack\WPGuard\V001\Saloon\Contracts\Response): (\Anystack\WPGuard\V001\Saloon\Contracts\Response|void) $callable
     * @param bool $prepend
     * @param string|null $name
     * @return $this
     */
    public function onResponse(callable $callable, bool $prepend = false, ?string $name = null): static;

    /**
     * Process the request pipeline.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest
     */
    public function executeRequestPipeline(PendingRequest $pendingRequest): PendingRequest;

    /**
     * Process the response pipeline.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     */
    public function executeResponsePipeline(Response $response): Response;

    /**
     * Merge in another middleware pipeline.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MiddlewarePipeline $middlewarePipeline
     * @return $this
     */
    public function merge(self $middlewarePipeline): static;

    /**
     * Get the request pipeline
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Pipeline
     */
    public function getRequestPipeline(): Pipeline;

    /**
     * Get the response pipeline
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Pipeline
     */
    public function getResponsePipeline(): Pipeline;
}
