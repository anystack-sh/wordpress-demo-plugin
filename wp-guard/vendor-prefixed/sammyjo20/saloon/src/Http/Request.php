<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http;

use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Traits\Bootable;
use Anystack\WPGuard\V001\Saloon\Traits\Makeable;
use Anystack\WPGuard\V001\Saloon\Traits\Conditionable;
use Anystack\WPGuard\V001\Saloon\Traits\HasMockClient;
use Anystack\WPGuard\V001\Saloon\Traits\HandlesExceptions;
use Anystack\WPGuard\V001\Saloon\Traits\Auth\AuthenticatesRequests;
use Anystack\WPGuard\V001\Saloon\Traits\Request\CastDtoFromResponse;
use Anystack\WPGuard\V001\Saloon\Traits\Responses\HasCustomResponses;
use Anystack\WPGuard\V001\Saloon\Contracts\Request as RequestContract;
use Anystack\WPGuard\V001\Saloon\Traits\RequestProperties\HasRequestProperties;

abstract class Request implements RequestContract
{
    use AuthenticatesRequests;
    use HasRequestProperties;
    use CastDtoFromResponse;
    use HasCustomResponses;
    use HandlesExceptions;
    use HasMockClient;
    use Conditionable;
    use Bootable;
    use Makeable;

    /**
     * Define the HTTP method.
     *
     * @var \Anystack\WPGuard\V001\Saloon\Enums\Method
     */
    protected Method $method;

    /**
     * Get the method of the request.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Enums\Method
     */
    public function getMethod(): Method
    {
        return $this->method;
    }
}
