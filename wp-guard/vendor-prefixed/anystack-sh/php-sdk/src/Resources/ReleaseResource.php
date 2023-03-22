<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\DeleteReleaseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\GetReleaseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\UpdateReleaseRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class ReleaseResource extends Resource
{
    public function get(): Response
    {
        return $this->connector->send(new GetReleaseRequest($this->productId, $this->releaseId));
    }

    public function update(array $parameters): Response
    {
        return $this->connector->send(new UpdateReleaseRequest($this->productId, $this->releaseId, $parameters));
    }

    public function delete(): Response
    {
        return $this->connector->send(new DeleteReleaseRequest($this->productId, $this->releaseId));
    }

    public function asset($assetId): AssetResource
    {
        return new AssetResource(
            connector: $this->connector,
            productId: $this->productId,
            releaseId: $this->releaseId,
            assetId: $assetId,
        );
    }

    public function assets(): AssetsResource
    {
        return new AssetsResource(
            connector: $this->connector,
            productId: $this->productId,
            releaseId: $this->releaseId
        );
    }
}
