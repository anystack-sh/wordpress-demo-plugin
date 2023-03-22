<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http;

use Throwable;
use Anystack\WPGuard\V001\Saloon\Traits\Macroable;
use Anystack\WPGuard\V001\Saloon\Contracts\Request;
use Anystack\WPGuard\V001\Saloon\Repositories\ArrayStore;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Psr\Http\Message\StreamInterface;
use Psr\Http\Message\ResponseInterface;
use Anystack\WPGuard\V001\Saloon\Traits\Responses\HasResponseHelpers;
use Anystack\WPGuard\V001\Saloon\Contracts\Response as ResponseContract;
use Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore as ArrayStoreContract;

class Response implements ResponseContract
{
    use Macroable;
    use HasResponseHelpers;

    /**
     * The PSR response from the sender.
     *
     * @var \Psr\Http\Message\ResponseInterface
     */
    protected ResponseInterface $psrResponse;

    /**
     * The pending request that has all the request properties
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest
     */
    protected PendingRequest $pendingRequest;

    /**
     * The original sender exception
     *
     * @var \Throwable|null
     */
    protected ?Throwable $senderException = null;

    /**
     * Create a new response instance.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @param \Psr\Http\Message\ResponseInterface $psrResponse
     * @param \Throwable|null $senderException
     */
    public function __construct(ResponseInterface $psrResponse, PendingRequest $pendingRequest, Throwable $senderException = null)
    {
        $this->psrResponse = $psrResponse;
        $this->pendingRequest = $pendingRequest;
        $this->senderException = $senderException;
    }

    /**
     * Create a new response instance
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @param \Psr\Http\Message\ResponseInterface $psrResponse
     * @param \Throwable|null $senderException
     * @return static
     */
    public static function fromPsrResponse(ResponseInterface $psrResponse, PendingRequest $pendingRequest, ?Throwable $senderException = null): static
    {
        return new static($psrResponse, $pendingRequest, $senderException);
    }

    /**
     * Get the pending request that created the response.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest
     */
    public function getPendingRequest(): PendingRequest
    {
        return $this->pendingRequest;
    }

    /**
     * Get the original request that created the response.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Request
     */
    public function getRequest(): Request
    {
        return $this->pendingRequest->getRequest();
    }

    /**
     * Create a PSR response from the raw response.
     *
     * @return \Psr\Http\Message\ResponseInterface
     */
    public function getPsrResponse(): ResponseInterface
    {
        return $this->psrResponse;
    }

    /**
     * Get the body of the response as string.
     *
     * @return string
     */
    public function body(): string
    {
        return (string)$this->stream();
    }

    /**
     * Get the body as a stream. Don't forget to close the stream after using ->close().
     *
     * @return \Psr\Http\Message\StreamInterface
     */
    public function stream(): StreamInterface
    {
        return $this->psrResponse->getBody();
    }

    /**
     * Get the headers from the response.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\ArrayStore
     */
    public function headers(): ArrayStoreContract
    {
        $headers = array_map(static function (array $header) {
            return count($header) === 1 ? $header[0] : $header;
        }, $this->psrResponse->getHeaders());

        return new ArrayStore($headers);
    }

    /**
     * Get the status code of the response.
     *
     * @return int
     */
    public function status(): int
    {
        return $this->psrResponse->getStatusCode();
    }

    /**
     * Get the original sender exception
     *
     * @return \Throwable|null
     */
    public function getSenderException(): ?Throwable
    {
        return $this->senderException;
    }
}
