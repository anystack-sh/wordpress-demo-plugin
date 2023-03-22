<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Helpers;

use Throwable;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\ClientException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\ServerException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\RequestException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\NotFoundException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\ForbiddenException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\UnauthorizedException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\GatewayTimeoutException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\RequestTimeOutException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\TooManyRequestsException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\MethodNotAllowedException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\ServiceUnavailableException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\InternalServerErrorException;
use Anystack\WPGuard\V001\Saloon\Exceptions\Request\Statuses\UnprocessableEntityException;

class RequestExceptionHelper
{
    /**
     * Create the request exception from a response
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @param \Throwable|null $previous
     * @return \Anystack\WPGuard\V001\Saloon\Exceptions\Request\RequestException
     */
    public static function create(Response $response, Throwable $previous = null): RequestException
    {
        $status = $response->status();

        $requestException = match (true) {
            // Built-in exceptions
            $status === 401 => UnauthorizedException::class,
            $status === 403 => ForbiddenException::class,
            $status === 404 => NotFoundException::class,
            $status === 405 => MethodNotAllowedException::class,
            $status === 408 => RequestTimeOutException::class,
            $status === 422 => UnprocessableEntityException::class,
            $status === 429 => TooManyRequestsException::class,
            $status === 500 => InternalServerErrorException::class,
            $status === 503 => ServiceUnavailableException::class,
            $status === 504 => GatewayTimeoutException::class,

            // Fall-back exceptions
            $response->serverError() => ServerException::class,
            $response->clientError() => ClientException::class,
            default => RequestException::class,
        };

        return new $requestException($response, null, 0, $previous);
    }
}
