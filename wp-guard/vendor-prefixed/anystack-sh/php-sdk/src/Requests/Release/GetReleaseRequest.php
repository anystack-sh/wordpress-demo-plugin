<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release;

use Anystack\WPGuard\V001\Anystack\Sdk\Objects\Release;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;

class GetReleaseRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->productId.'/releases/'.$this->releaseId;
    }

    public function __construct(protected string $productId, protected string $releaseId)
    {
    }

    public function createDtoFromResponse(Response $response): Release
    {
        return Release::fromResponse($response);
    }
}
