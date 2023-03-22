<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts\DataObjects;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;

interface WithResponse
{
    /**
     * Set the response on the data object.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return $this
     */
    public function setResponse(Response $response): static;

    /**
     * Get the response on the data object.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Response
     */
    public function getResponse(): Response;
}
