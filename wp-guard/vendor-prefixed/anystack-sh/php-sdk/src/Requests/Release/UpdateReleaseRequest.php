<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release;

use Anystack\WPGuard\V001\Anystack\Sdk\Objects\Release;
use Anystack\WPGuard\V001\Saloon\Contracts\Body\HasBody;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;
use Anystack\WPGuard\V001\Saloon\Traits\Body\HasJsonBody;

class UpdateReleaseRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->productId.'/releases/'.$this->releaseId;
    }

    public function __construct(protected string $productId, protected string $releaseId, protected array $parameters = [])
    {
    }

    protected function defaultBody(): array
    {
        return $this->parameters;
    }

    public function createDtoFromResponse(Response $response): Release
    {
        return Release::fromResponse($response);
    }
}
