<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Asset;

use Anystack\WPGuard\V001\Anystack\Sdk\Objects\AssetCollection;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;

class GetAssetsRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->productId.'/releases/'.$this->releaseId.'/assets';
    }

    public function __construct(protected string $productId, protected string $releaseId, protected int $page = 1)
    {
    }

    protected function defaultQuery(): array
    {
        return [
            'page' => $this->page,
        ];
    }

    public function createDtoFromResponse(Response $response): AssetCollection
    {
        return AssetCollection::fromResponse($response);
    }
}
