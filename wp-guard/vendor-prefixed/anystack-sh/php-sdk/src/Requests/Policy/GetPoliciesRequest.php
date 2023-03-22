<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Policy;

use Anystack\WPGuard\V001\Anystack\Sdk\Objects\PolicyCollection;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;

class GetPoliciesRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->productId.'/policies';
    }

    public function __construct(protected string $productId, protected int $page = 1)
    {
    }

    protected function defaultQuery(): array
    {
        return [
            'page' => $this->page,
        ];
    }

    public function createDtoFromResponse(Response $response): PolicyCollection
    {
        return PolicyCollection::fromResponse($response);
    }
}
