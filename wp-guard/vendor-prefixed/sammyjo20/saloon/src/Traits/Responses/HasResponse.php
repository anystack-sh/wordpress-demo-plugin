<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Responses;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;

trait HasResponse
{
    /**
     * The original response.
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\Response
     */
    protected Response $response;

    /**
     * Set the response on the data object.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return $this
     */
    public function setResponse(Response $response): static
    {
        $this->response = $response;

        return $this;
    }

    /**
     * Get the response on the data object.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     */
    public function getResponse(): Response
    {
        return $this->response;
    }
}
