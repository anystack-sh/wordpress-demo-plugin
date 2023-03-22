<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Connector;

use LogicException;
use Anystack\WPGuard\V001\Saloon\Contracts\Request;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Http\PendingRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\MockClient;
use Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\RequestException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\FatalRequestException;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest as PendingRequestContract;

trait SendsRequests
{
    /**
     * Send a request
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Request $request
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     * @throws \ReflectionException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\InvalidResponseClassException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\PendingRequestException
     */
    public function send(Request $request, MockClient $mockClient = null): Response
    {
        // 🚀 ... 🪐  ... 💫

        return $this->createPendingRequest($request, $mockClient)->send();
    }

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
     * @throws \ReflectionException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\InvalidResponseClassException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\PendingRequestException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\Request\FatalRequestException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\Request\RequestException
     */
    public function sendAndRetry(Request $request, int $maxAttempts, int $interval = 0, callable $handleRetry = null, bool $throw = true, MockClient $mockClient = null): Response
    {
        $currentAttempt = 0;
        $pendingRequest = $this->createPendingRequest($request, $mockClient);

        while ($currentAttempt < $maxAttempts) {
            $currentAttempt++;

            // When the current attempt is greater than one, we will pause to wait
            // for the interval.

            if ($currentAttempt > 1) {
                usleep($interval * 1000);
            }

            try {
                // We'll attempt to send the PendingRequest. We'll also use the throw
                // method which will throw an exception if the request has failed.

                return $pendingRequest->send()->throw();
            } catch (FatalRequestException|RequestException $exception) {
                // We won't create another pending request if our current attempt is
                // the max attempts we can make

                if ($currentAttempt === $maxAttempts) {
                    return $exception instanceof RequestException && $throw === false ? $exception->getResponse() : throw $exception;
                }

                $pendingRequest = $this->createPendingRequest($request, $mockClient);

                // When either the FatalRequestException happens or the RequestException
                // happens, we should catch it and check if we should retry. If someone
                // has provided a callable into $handleRetry, we'll wait for the result
                // of the callable to retry.

                if (is_null($handleRetry) || $handleRetry($exception, $pendingRequest) === true) {
                    continue;
                }

                // If we should not retry, we need to return the last response. If the
                // exception was a RequestException, we should return the response,
                // otherwise we'll throw the exception.

                return $exception instanceof RequestException && $throw === false ? $exception->getResponse() : throw $exception;
            }
        }

        throw new LogicException('Maximum number of attempts has been reached.');
    }

    /**
     * Send a request asynchronously
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Request $request
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface
     * @throws \ReflectionException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\InvalidResponseClassException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\PendingRequestException
     */
    public function sendAsync(Request $request, MockClient $mockClient = null): PromiseInterface
    {
        // 🚀 ... 🪐  ... 💫

        return $this->createPendingRequest($request, $mockClient)->sendAsync();
    }

    /**
     * Create a new PendingRequest
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Request $request
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest
     * @throws \ReflectionException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\InvalidResponseClassException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\PendingRequestException
     */
    public function createPendingRequest(Request $request, MockClient $mockClient = null): PendingRequestContract
    {
        return new PendingRequest($this, $request, $mockClient);
    }
}
