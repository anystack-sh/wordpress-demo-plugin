<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Responses;

trait HasCustomResponses
{
    /**
     * Specify a default response.
     *
     * When null or an empty string, the response on the sender will be used.
     *
     * @var class-string<\Saloon\Contracts\Response>|null
     */
    protected ?string $response = null;

    /**
     * Resolve the custom response class
     *
     * @return class-string<\Saloon\Contracts\Response>|null
     */
    public function resolveResponseClass(): ?string
    {
        return $this->response ?? null;
    }
}
