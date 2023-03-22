<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\License\ActivateLicenseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\License\DeleteLicenseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\License\GetLicenseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\License\UpdateLicenseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\License\ValidateLicenseRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class LicenseResource extends Resource
{
    public function get(): Response
    {
        return $this->connector->send(new GetLicenseRequest($this->productId, $this->licenseId));
    }

    public function update(array $parameters): Response
    {
        return $this->connector->send(new UpdateLicenseRequest($this->productId, $this->licenseId, $parameters));
    }

    public function delete(): Response
    {
        return $this->connector->send(new DeleteLicenseRequest($this->productId, $this->licenseId));
    }

    public function activate(array $parameters): Response
    {
        return $this->connector->send(new ActivateLicenseRequest($this->productId, $parameters));
    }

    public function validate(array $parameters): Response
    {
        return $this->connector->send(new ValidateLicenseRequest($this->productId, $parameters));
    }

    public function activation($activationId): AssetResource
    {
        return new AssetResource(
            connector: $this->connector,
            productId: $this->productId,
            releaseId: $this->releaseId,
            assetId: $activationId,
        );
    }

    public function activations(): AssetsResource
    {
        return new AssetsResource(
            connector: $this->connector,
            productId: $this->productId,
            licenseId: $this->licenseId
        );
    }
}
