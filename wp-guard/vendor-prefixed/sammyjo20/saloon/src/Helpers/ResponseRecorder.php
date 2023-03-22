<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Helpers;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Data\RecordedResponse;

class ResponseRecorder
{
    /**
     * Record a response
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return \Anystack\WPGuard\V001\Saloon\Data\RecordedResponse
     */
    public static function record(Response $response): RecordedResponse
    {
        return RecordedResponse::fromResponse($response);
    }
}
