<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Request;

use Anystack\WPGuard\V001\Saloon\Contracts\Sender;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Contracts\Connector;
use Anystack\WPGuard\V001\Saloon\Contracts\MockClient;
use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface;

trait HasConnector
{
    /**
     * The loaded connector used in requests.
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\Connector|null
     */
    private ?Connector $loadedConnector = null;

    /**
     *  Retrieve the loaded connector.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Connector
     */
    public function connector(): Connector
    {
        return $this->loadedConnector ??= $this->resolveConnector();
    }

    /**
     * Set the loaded connector at runtime.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Connector $connector
     * @return $this
     */
    public function setConnector(Connector $connector): static
    {
        $this->loadedConnector = $connector;

        return $this;
    }

    /**
     * Create a new connector instance.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Connector
     */
    protected function resolveConnector(): Connector
    {
        return new $this->connector;
    }

    /**
     * Access the HTTP sender
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Sender
     */
    public function sender(): Sender
    {
        return $this->connector()->sender();
    }

    /**
     * Create a pending request
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest
     */
    public function createPendingRequest(MockClient $mockClient = null): PendingRequest
    {
        return $this->connector()->createPendingRequest($this, $mockClient);
    }

    /**
     * Send a request synchronously
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     */
    public function send(MockClient $mockClient = null): Response
    {
        return $this->connector()->send($this, $mockClient);
    }

    /**
     * Send a request asynchronously
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null $mockClient
     * @return \Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface
     */
    public function sendAsync(MockClient $mockClient = null): PromiseInterface
    {
        return $this->connector()->sendAsync($this, $mockClient);
    }
}
