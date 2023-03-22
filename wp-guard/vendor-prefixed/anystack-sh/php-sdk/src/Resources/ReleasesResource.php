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
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\GetReleasesRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\UpdateReleaseRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class ReleasesResource extends Resource
{
    public function all(int $page = 1): Response
    {
        return $this->connector->send(new GetReleasesRequest($this->productId, $page));
    }

    public function get(string $releaseId): Response
    {
        return $this->connector->send(new GetReleaseRequest($this->productId, $releaseId));
    }

    public function update(string $releaseId, array $parameters): Response
    {
        return $this->connector->send(new UpdateReleaseRequest($this->productId, $releaseId, $parameters));
    }

    public function delete(string $productId): Response
    {
        return $this->connector->send(new DeleteReleaseRequest($this->productId, $productId));
    }
}
