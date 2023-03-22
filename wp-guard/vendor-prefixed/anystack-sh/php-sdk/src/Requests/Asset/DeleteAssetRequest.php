<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Asset;

use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;

class DeleteAssetRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->productId.'/releases/'.$this->releaseId.'/assets/'.$this->assetId;
    }

    public function __construct(protected string $productId, protected string $releaseId, protected string $assetId)
    {
    }
}
