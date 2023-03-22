<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product\DeleteProductRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product\GetProductRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product\UpdateProductRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class ProductResource extends Resource
{
    public function get(): Response
    {
        return $this->connector->send(new GetProductRequest($this->productId));
    }

    public function update(array $parameters): Response
    {
        return $this->connector->send(new UpdateProductRequest($this->productId, $parameters));
    }

    public function delete(): Response
    {
        return $this->connector->send(new DeleteProductRequest($this->productId));
    }

    public function releases(): ReleasesResource
    {
        return new ReleasesResource(connector: $this->connector, productId: $this->productId);
    }

    public function release($releaseId): ReleaseResource
    {
        return new ReleaseResource(
            connector: $this->connector,
            productId: $this->productId,
            releaseId: $releaseId
        );
    }

    public function policies(): PoliciesResource
    {
        return new PoliciesResource(connector: $this->connector, productId: $this->productId);
    }

    public function policy($policyId): PolicyResource
    {
        return new PolicyResource(connector: $this->connector, productId: $this->productId, policyId: $policyId);
    }

    public function licenses(): LicensesResource
    {
        return new LicensesResource(connector: $this->connector, productId: $this->productId);
    }

    public function license($licenseId): LicenseResource
    {
        return new LicenseResource(connector: $this->connector, productId: $this->productId, licenseId: $licenseId);
    }
}
