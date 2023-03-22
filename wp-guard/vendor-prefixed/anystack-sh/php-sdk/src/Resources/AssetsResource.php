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
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Asset\GetAssetsRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class AssetsResource extends Resource
{
    public function all(int $page = 1): Response
    {
        return $this->connector->send(new GetAssetsRequest($this->productId, $this->releaseId, $page));
    }

    public function get(string $assetId): Response
    {
        return $this->connector->send(new GetAssetRequest($this->productId, $this->releaseId, $assetId));
    }

    public function delete(string $assetId): Response
    {
        return $this->connector->send(new DeleteAssetRequest($this->productId, $this->releaseId, $assetId));
    }
}
