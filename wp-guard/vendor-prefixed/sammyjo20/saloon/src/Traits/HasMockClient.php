<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits;

use Anystack\WPGuard\V001\Saloon\Contracts\MockClient;

trait HasMockClient
{
    /**
     * Mock Client
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null
     */
    protected ?MockClient $mockClient = null;

    /**
     * Specify a mock client.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient $mockClient
     * @return $this
     */
    public function withMockClient(MockClient $mockClient): static
    {
        $this->mockClient = $mockClient;

        return $this;
    }

    /**
     * Get the mock client.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null
     */
    public function getMockClient(): ?MockClient
    {
        return $this->mockClient;
    }

    /**
     * Determine if the instance has a mock client
     *
     * @return bool
     */
    public function hasMockClient(): bool
    {
        return $this->mockClient instanceof MockClient;
    }
}
