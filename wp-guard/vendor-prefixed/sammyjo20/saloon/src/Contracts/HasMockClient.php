<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

interface HasMockClient
{
    /**
     * Specify a mock client.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\MockClient $mockClient
     * @return $this
     */
    public function withMockClient(MockClient $mockClient): static;

    /**
     * Get the mock client.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\MockClient|null
     */
    public function getMockClient(): ?MockClient;

    /**
     * Determine if the instance has a mock client
     *
     * @return bool
     */
    public function hasMockClient(): bool;
}
