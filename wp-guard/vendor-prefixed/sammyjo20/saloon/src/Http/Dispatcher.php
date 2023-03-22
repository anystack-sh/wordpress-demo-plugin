<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http;

use Anystack\WPGuard\V001\Saloon\Contracts\Sender;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface;
use Anystack\WPGuard\V001\Saloon\Http\Senders\SimulatedSender;
use Anystack\WPGuard\V001\Saloon\Contracts\Dispatcher as DispatcherContract;

class Dispatcher implements DispatcherContract
{
    /**
     * Constructor
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     */
    public function __construct(protected PendingRequest $pendingRequest)
    {
        //
    }

    /**
     * Execute the action
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response|PromiseInterface
     */
    public function execute(): Response|PromiseInterface
    {
        $pendingRequest = $this->pendingRequest;

        // Let's start by checking if the pending request needs to make a request.
        // If SimulatedResponsePayload has been set on the instance than we need
        // to create the SimulatedResponse and return that. Otherwise, we
        // will send a real request to the sender.

        $response = $this->getSender()->sendRequest($pendingRequest, $pendingRequest->isAsynchronous());

        // Next we will need to run the response pipeline. If the response
        // is a Response we can run it directly, but if it is
        // a PromiseInterface we need to add a step to execute
        // the response pipeline.

        if ($response instanceof Response) {
            return $pendingRequest->executeResponsePipeline($response);
        }

        return $response->then(fn (Response $response) => $pendingRequest->executeResponsePipeline($response));
    }

    /**
     * Get the sender
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Sender
     */
    protected function getSender(): Sender
    {
        $pendingRequest = $this->pendingRequest;

        return $pendingRequest->hasSimulatedResponsePayload() ? new SimulatedSender : $pendingRequest->getSender();
    }
}
