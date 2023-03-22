<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Request;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;

trait CastDtoFromResponse
{
    /**
     * Cast the response to a DTO.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return mixed
     */
    public function createDtoFromResponse(Response $response): mixed
    {
        return null;
    }
}
