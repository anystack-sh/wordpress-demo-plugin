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
use Anystack\WPGuard\V001\Saloon\Repositories\Body\FormBodyRepository;

trait HasFormBody
{
    use ChecksForHasBody;

    /**
     * Body Repository
     *
     * @var \Anystack\WPGuard\V001\Saloon\Repositories\Body\FormBodyRepository
     */
    protected FormBodyRepository $body;

    /**
     * Boot the HasFormBody trait
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @return void
     */
    public function bootHasFormBody(PendingRequest $pendingRequest): void
    {
        $pendingRequest->headers()->add('Content-Type', 'application/x-www-form-urlencoded');
    }

    /**
     * Retrieve the data repository
     *
     * @return \Anystack\WPGuard\V001\Saloon\Repositories\Body\FormBodyRepository
     */
    public function body(): FormBodyRepository
    {
        return $this->body ??= new FormBodyRepository($this->defaultBody());
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
