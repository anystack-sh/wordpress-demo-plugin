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
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\License\GetLicensesRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\License\UpdateLicenseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\License\ValidateLicenseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\DeleteReleaseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\GetReleaseRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\GetReleasesRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Release\UpdateReleaseRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class LicensesResource extends Resource
{
    public function all(int $page = 1): Response
    {
        return $this->connector->send(new GetLicensesRequest($this->productId, $page));
    }

    public function get(string $licenseId): Response
    {
        return $this->connector->send(new GetLicenseRequest($this->productId, $licenseId));
    }

    public function update(string $licenseId, array $parameters): Response
    {
        return $this->connector->send(new UpdateLicenseRequest($this->productId, $licenseId, $parameters));
    }

    public function delete(string $licenseId): Response
    {
        return $this->connector->send(new DeleteLicenseRequest($this->productId, $licenseId));
    }

    public function activate(array $parameters): Response
    {
        return $this->connector->send(new ActivateLicenseRequest($this->productId, $parameters));
    }

    public function validate(array $parameters): Response
    {
        return $this->connector->send(new ValidateLicenseRequest($this->productId, $parameters));
    }
}
