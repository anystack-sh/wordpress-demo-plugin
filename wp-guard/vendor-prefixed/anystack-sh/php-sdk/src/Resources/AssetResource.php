<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Asset\DeleteAssetRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Asset\GetAssetRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class AssetResource extends Resource
{
    public function get(): Response
    {
        return $this->connector->send(new GetAssetRequest($this->productId, $this->releaseId, $this->assetId));
    }

    public function delete(): Response
    {
        return $this->connector->send(new DeleteAssetRequest($this->productId, $this->releaseId, $this->assetId));
    }
}
