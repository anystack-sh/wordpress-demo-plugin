<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Faking;

use Closure;
use Throwable;
use Anystack\WPGuard\V001\Saloon\Traits\Makeable;
use Anystack\WPGuard\V001\Saloon\Repositories\ArrayStore;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Psr\Http\Message\ResponseInterface;
use Anystack\WPGuard\V001\Saloon\Contracts\Body\BodyRepository;
use Anystack\WPGuard\V001\GuzzleHttp\Psr7\Response as GuzzleResponse;
use Anystack\WPGuard\V001\Saloon\Repositories\Body\JsonBodyRepository;
use Anystack\WPGuard\V001\Saloon\Repositories\Body\StringBodyRepository;
use Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore as ArrayStoreContract;
use Anystack\WPGuard\V001\Saloon\Contracts\SimulatedResponsePayload as SimulatedResponsePayloadContract;

class SimulatedResponsePayload implements SimulatedResponsePayloadContract
{
    use Makeable;

    /**
     * HTTP Status Code
     *
     * @var int
     */
    protected int $status;

    /**
     * Headers
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    protected ArrayStoreContract $headers;

    /**
     * Request Body
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\Body\BodyRepository
     */
    protected BodyRepository $body;

    /**
     * Exception Closure
     *
     * @var \Closure|null
     */
    protected ?Closure $responseException = null;

    /**
     * Create a new mock response
     *
     * @param array<string, mixed>|string $body
     * @param int $status
     * @param array<string, mixed> $headers
     */
    public function __construct(array|string $body = [], int $status = 200, array $headers = [])
    {
        $this->body = is_array($body) ? new JsonBodyRepository($body) : new StringBodyRepository($body);
        $this->status = $status;
        $this->headers = new ArrayStore($headers);
    }

    /**
     * Create a new mock response from a fixture
     *
     * @param string $name
     * @return \Anystack\WPGuard\V001\Saloon\Http\Faking\Fixture
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\DirectoryNotFoundException
     */
    public static function fixture(string $name): Fixture
    {
        return new Fixture($name);
    }

    /**
     * Get the status from the responses
     *
     * @return int
     */
    public function getStatus(): int
    {
        return $this->status;
    }

    /**
     * Get the headers
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    public function getHeaders(): ArrayStoreContract
    {
        return $this->headers;
    }

    /**
     * Get the response body
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Body\BodyRepository
     */
    public function getBody(): BodyRepository
    {
        return $this->body;
    }

    /**
     * Get the formatted body on the response.
     *
     * @return string
     */
    public function getBodyAsString(): string
    {
        return (string)$this->body;
    }

    /**
     * Throw an exception on the request.
     *
     * @param \Closure|\Throwable $value
     * @return $this
     */
    public function throw(Closure|Throwable $value): static
    {
        $closure = $value instanceof Throwable ? static fn () => $value : $value;

        $this->responseException = $closure;

        return $this;
    }

    /**
     * Checks if the response throws an exception.
     *
     * @return bool
     */
    public function throwsException(): bool
    {
        return $this->responseException instanceof Closure;
    }

    /**
     * Invoke the exception.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return \Throwable|null
     */
    public function getException(PendingRequest $pendingRequest): ?Throwable
    {
        if (! $this->throwsException()) {
            return null;
        }

        return call_user_func($this->responseException, $pendingRequest);
    }

    /**
     * Get the response as a ResponseInterface
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getPsrResponse(): ResponseInterface
    {
        return new GuzzleResponse($this->getStatus(), $this->getHeaders()->all(), $this->getBodyAsString());
    }
}
