<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Body;

use Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest;
use Anystack\WPGuard\V001\Saloon\Repositories\Body\JsonBodyRepository;

trait HasJsonBody
{
    use ChecksForHasBody;

    /**
     * Body Repository
     *
     * @var \Anystack\WPGuard\V001\Saloon\Repositories\Body\JsonBodyRepository
     */
    protected JsonBodyRepository $body;

    /**
     * Boot the plugin
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function bootHasJsonBody(PendingRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add('Content-Type', 'application/json');
    }

    /**
     * Retrieve the data repository
     *
     * @return \Anystack\WPGuard\V001\Saloon\Repositories\Body\JsonBodyRepository
     */
    public function body(): JsonBodyRepository
    {
        return $this->body ??= new JsonBodyRepository($this->defaultBody());
    }

    /**
     * Default body
     *
     * @return array<string, mixed>
     */
    protected function defaultBody(): array
    {
        return [];
    }
}
