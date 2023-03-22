<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Objects;

use Anystack\WPGuard\V001\Saloon\Contracts\DataObjects\WithResponse;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Traits\Responses\HasResponse;

class Product implements WithResponse
{
    use HasResponse;

    public function __construct(
        public string $id,
        public string $name,
        public string $slug,
        public string $type,
        public bool $distribution,
        public bool $publicDistributionPage,
        public bool $distributionRequiresLicense,
        public string $createdAt,
        public string $updatedAt,
        public array $links,
        public ?string $url = null,
        public ?string $logo = null,
        public ?string $updater = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new static(
            id: $data['id'],
            name: $data['name'],
            slug: $data['slug'],
            type: $data['type'],
            distribution: $data['distribution'],
            publicDistributionPage: $data['public_distribution_page'],
            distributionRequiresLicense: $data['distribution_requires_license'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            links: $data['links'],
            url: $data['url'] ?? null,
            logo: $data['logo'] ?? null,
            updater: $data['updater'] ?? null,
        );
    }

    public static function fromResponse(Response $response): self
    {
        return static::fromArray($response->json('data'));
    }
}
