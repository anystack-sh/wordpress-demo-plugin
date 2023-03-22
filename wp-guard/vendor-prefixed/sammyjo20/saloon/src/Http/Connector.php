<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http;

use Anystack\WPGuard\V001\Saloon\Traits\Bootable;
use Anystack\WPGuard\V001\Saloon\Traits\Makeable;
use Anystack\WPGuard\V001\Saloon\Traits\HasDebugging;
use Anystack\WPGuard\V001\Saloon\Traits\Conditionable;
use Anystack\WPGuard\V001\Saloon\Traits\HasMockClient;
use Anystack\WPGuard\V001\Saloon\Traits\Connector\HasPool;
use Anystack\WPGuard\V001\Saloon\Traits\HandlesExceptions;
use Anystack\WPGuard\V001\Saloon\Traits\Connector\HasSender;
use Anystack\WPGuard\V001\Saloon\Traits\Connector\SendsRequests;
use Anystack\WPGuard\V001\Saloon\Traits\Auth\AuthenticatesRequests;
use Anystack\WPGuard\V001\Saloon\Traits\RequestProperties\HasDelay;
use Anystack\WPGuard\V001\Saloon\Traits\Request\CastDtoFromResponse;
use Anystack\WPGuard\V001\Saloon\Traits\Responses\HasCustomResponses;
use Anystack\WPGuard\V001\Saloon\Contracts\Connector as ConnectorContract;
use Anystack\WPGuard\V001\Saloon\Traits\RequestProperties\HasRequestProperties;
use Anystack\WPGuard\V001\Saloon\Contracts\HasDebugging as HasDebuggingContract;

abstract class Connector implements ConnectorContract, HasDebuggingContract
{
    use AuthenticatesRequests;
    use HasRequestProperties;
    use CastDtoFromResponse;
    use HasCustomResponses;
    use HandlesExceptions;
    use HasMockClient;
    use SendsRequests;
    use Conditionable;
    use HasSender;
    use Bootable;
    use Makeable;
    use HasPool;
    use HasDelay;
    use HasDebugging;
}
