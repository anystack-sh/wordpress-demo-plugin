<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Senders;

use Exception;
use Anystack\WPGuard\V001\Saloon\Enums\Timeout;
use Anystack\WPGuard\V001\GuzzleHttp\HandlerStack;
use Anystack\WPGuard\V001\GuzzleHttp\Psr7\Request;
use Anystack\WPGuard\V001\Saloon\Contracts\Sender;
use Anystack\WPGuard\V001\GuzzleHttp\RequestOptions;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Anystack\WPGuard\V001\GuzzleHttp\Client as GuzzleClient;
use Psr\Http\Message\ResponseInterface;
use Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface;
use Anystack\WPGuard\V001\GuzzleHttp\Exception\RequestException;
use Anystack\WPGuard\V001\GuzzleHttp\Exception\TransferException;
use Anystack\WPGuard\V001\Saloon\Repositories\Body\FormBodyRepository;
use Anystack\WPGuard\V001\Saloon\Repositories\Body\JsonBodyRepository;
use Anystack\WPGuard\V001\Saloon\Contracts\Response as ResponseContract;
use Anystack\WPGuard\V001\Saloon\Repositories\Body\StringBodyRepository;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\FatalRequestException;
use Anystack\WPGuard\V001\Saloon\Repositories\Body\MultipartBodyRepository;

class GuzzleSender implements Sender
{
    /**
     * The Guzzle client.
     *
     * @var \Anystack\WPGuard\V001\GuzzleHttp\Client
     */
    protected GuzzleClient $client;

    /**
     * Guzzle's Handler Stack.
     *
     * @var \Anystack\WPGuard\V001\GuzzleHttp\HandlerStack
     */
    protected HandlerStack $handlerStack;

    /**
     * Constructor
     *
     * Create the HTTP client.
     */
    public function __construct()
    {
        $this->client = $this->createGuzzleClient();
    }

    /**
     * Create a new Guzzle client
     *
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Client
     */
    protected function createGuzzleClient(): GuzzleClient
    {
        // We'll use HandlerStack::create as it will create a default
        // handler stack with the default Guzzle middleware like
        // http_errors, cookies etc.

        $this->handlerStack = HandlerStack::create();

        // Now we'll return new Guzzle client with some default request
        // options configured. We'll also define the handler stack we
        // created above. Since it's a property, developers may
        // customise or add middleware to the handler stack.

        return new GuzzleClient([
            RequestOptions::CONNECT_TIMEOUT => Timeout::CONNECT->value,
            RequestOptions::TIMEOUT => Timeout::REQUEST->value,
            RequestOptions::HTTP_ERRORS => true,
            'handler' => $this->handlerStack,
        ]);
    }

    /**
     * Send a request
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @param bool $asynchronous
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response|\Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface
     * @throws \Anystack\WPGuard\V001\GuzzleHttp\Exception\GuzzleException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\Request\FatalRequestException
     */
    public function sendRequest(PendingRequest $pendingRequest, bool $asynchronous = false): ResponseContract|PromiseInterface
    {
        return $asynchronous === true
            ? $this->sendAsynchronousRequest($pendingRequest)
            : $this->sendSynchronousRequest($pendingRequest);
    }

    /**
     * Send a synchronous request.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     * @throws \Anystack\WPGuard\V001\GuzzleHttp\Exception\GuzzleException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\Request\FatalRequestException
     */
    protected function sendSynchronousRequest(PendingRequest $pendingRequest): ResponseContract
    {
        $guzzleRequest = $this->createGuzzleRequest($pendingRequest);
        $guzzleRequestOptions = $this->createRequestOptions($pendingRequest);

        try {
            $guzzleResponse = $this->client->send($guzzleRequest, $guzzleRequestOptions);
        } catch (TransferException $exception) {
            // When the exception wasn't a RequestException, we'll throw a fatal
            // exception as this is likely a ConnectException, but it will
            // catch any new ones Guzzle release.

            if (! $exception instanceof RequestException) {
                throw new FatalRequestException($exception, $pendingRequest);
            }

            // Otherwise, we'll create a response.

            return $this->createResponse($pendingRequest, $exception->getResponse(), $exception);
        }

        return $this->createResponse($pendingRequest, $guzzleResponse);
    }

    /**
     * Send an asynchronous request
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface
     */
    protected function sendAsynchronousRequest(PendingRequest $pendingRequest): PromiseInterface
    {
        $guzzleRequest = $this->createGuzzleRequest($pendingRequest);
        $guzzleRequestOptions = $this->createRequestOptions($pendingRequest);

        $promise = $this->client->sendAsync($guzzleRequest, $guzzleRequestOptions);

        return $this->processPromise($promise, $pendingRequest);
    }

    /**
     * Create the Guzzle request
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Psr7\Request
     */
    protected function createGuzzleRequest(PendingRequest $pendingRequest): Request
    {
        return new Request($pendingRequest->getMethod()->value, $pendingRequest->getUrl());
    }

    /**
     * Build up all the request options
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return array<RequestOptions::*, mixed>
     */
    protected function createRequestOptions(PendingRequest $pendingRequest): array
    {
        $requestOptions = [];

        if ($pendingRequest->headers()->isNotEmpty()) {
            $requestOptions[RequestOptions::HEADERS] = $pendingRequest->headers()->all();
        }

        if ($pendingRequest->query()->isNotEmpty()) {
            $requestOptions[RequestOptions::QUERY] = $pendingRequest->query()->all();
        }

        foreach ($pendingRequest->config()->all() as $configVariable => $value) {
            $requestOptions[$configVariable] = $value;
        }

        if ($pendingRequest->delay()->isNotEmpty()) {
            $requestOptions[RequestOptions::DELAY] = $pendingRequest->delay()->get();
        }

        $body = $pendingRequest->body();

        if (is_null($body) || $body->isEmpty()) {
            return $requestOptions;
        }

        match (true) {
            $body instanceof JsonBodyRepository => $requestOptions[RequestOptions::JSON] = $body->all(),
            $body instanceof MultipartBodyRepository => $requestOptions[RequestOptions::MULTIPART] = $body->toArray(),
            $body instanceof FormBodyRepository => $requestOptions[RequestOptions::FORM_PARAMS] = $body->all(),
            $body instanceof StringBodyRepository => $requestOptions[RequestOptions::BODY] = $body->all(),
            default => $requestOptions[RequestOptions::BODY] = (string)$body,
        };

        return $requestOptions;
    }

    /**
     * Create a response.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingSaloonRequest
     * @param \Psr\Http\Message\ResponseInterface $guzzleResponse
     * @param \Exception|null $exception
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     */
    protected function createResponse(PendingRequest $pendingSaloonRequest, ResponseInterface $guzzleResponse, Exception $exception = null): ResponseContract
    {
        /** @var class-string<\Saloon\Contracts\Response> $responseClass */
        $responseClass = $pendingSaloonRequest->getResponseClass();

        return $responseClass::fromPsrResponse($guzzleResponse, $pendingSaloonRequest, $exception);
    }

    /**
     * Update the promise provided by Guzzle.
     *
     * @param \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface $promise
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface
     */
    protected function processPromise(PromiseInterface $promise, PendingRequest $pendingRequest): PromiseInterface
    {
        return $promise
            ->then(
                function (ResponseInterface $guzzleResponse) use ($pendingRequest) {
                    // Instead of the promise returning a Guzzle response, we want to return
                    // a Saloon response.

                    return $this->createResponse($pendingRequest, $guzzleResponse);
                },
                function (TransferException $guzzleException) use ($pendingRequest) {
                    // When the exception wasn't a RequestException, we'll throw a fatal
                    // exception as this is likely a ConnectException, but it will
                    // catch any new ones Guzzle release.

                    if (! $guzzleException instanceof RequestException) {
                        throw new FatalRequestException($guzzleException, $pendingRequest);
                    }

                    // Otherwise we'll create a response to convert into an exception.
                    // This will run the exception through the exception handlers
                    // which allows the user to handle their own exceptions.

                    $response = $this->createResponse($pendingRequest, $guzzleException->getResponse(), $guzzleException);

                    // Throw the exception our way

                    throw $response->toException();
                }
            );
    }

    /**
     * Add a middleware to the handler stack.
     *
     * @param callable $callable
     * @param string $name
     * @return $this
     */
    public function addMiddleware(callable $callable, string $name = ''): static
    {
        $this->handlerStack->push($callable, $name);

        return $this;
    }

    /**
     * Overwrite the entire handler stack.
     *
     * @param \Anystack\WPGuard\V001\GuzzleHttp\HandlerStack $handlerStack
     * @return $this
     */
    public function setHandlerStack(HandlerStack $handlerStack): static
    {
        $this->handlerStack = $handlerStack;

        return $this;
    }

    /**
     * Get the handler stack.
     *
     * @return \Anystack\WPGuard\V001\GuzzleHttp\HandlerStack
     */
    public function getHandlerStack(): HandlerStack
    {
        return $this->handlerStack;
    }

    /**
     * Get the Guzzle client
     *
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Client
     */
    public function getGuzzleClient(): GuzzleClient
    {
        return $this->client;
    }
}
