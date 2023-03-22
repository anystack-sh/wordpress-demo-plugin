<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

use Closure;
use Throwable;
use Anystack\WPGuard\V001\Saloon\Http\Faking\Fixture;
use Psr\Http\Message\ResponseInterface;
use Anystack\WPGuard\V001\Saloon\Contracts\Body\BodyRepository;

/**
 * @method static static make(mixed $body = [], int $status = 200, array $headers = []) Create a new mock response
 */
interface SimulatedResponsePayload
{
    /**
     * Create a new mock response from a fixture
     *
     * @param string $name
     * @return \Anystack\WPGuard\V001\Saloon\Http\Faking\Fixture
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\DirectoryNotFoundException
     */
    public static function fixture(string $name): Fixture;

    /**
     * Get the status from the responses
     *
     * @return int
     */
    public function getStatus(): int;

    /**
     * Get the headers
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    public function getHeaders(): ArrayStore;

    /**
     * Get the response body
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Body\BodyRepository
     */
    public function getBody(): BodyRepository;

    /**
     * Get the formatted body on the response.
     *
     * @return string
     */
    public function getBodyAsString(): string;

    /**
     * Throw an exception on the request.
     *
     * @param \Closure|\Throwable $value
     * @return $this
     */
    public function throw(Closure|Throwable $value): static;

    /**
     * Checks if the response throws an exception.
     *
     * @return bool
     */
    public function throwsException(): bool;

    /**
     * Invoke the exception.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return \Throwable|null
     */
    public function getException(PendingRequest $pendingRequest): ?Throwable;

    /**
     * Get the response as a ResponseInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getPsrResponse(): ResponseInterface;
}
