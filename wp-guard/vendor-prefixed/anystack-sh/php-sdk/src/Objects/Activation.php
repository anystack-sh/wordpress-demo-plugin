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

class Activation implements WithResponse
{
    use HasResponse;

    public function __construct(
        public string $id,
        public string $licenseId,
        public string $fingerprint,
        public string $createdAt,
        public string $updatedAt,
        public array $links,
        public ?string $name = null,
        public ?string $hostname = null,
        public ?string $ip = null,
        public ?string $platform = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new static(
            id: $data['id'],
            licenseId: $data['license_id'],
            fingerprint: $data['fingerprint'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            links: $data['links'],
            name: $data['name'] ?? null,
            hostname: $data['hostname'] ?? null,
            ip: $data['ip'] ?? null,
            platform: $data['platform'] ?? null,
        );
    }

    public static function fromResponse(Response $response): self
    {
        return static::fromArray($response->json('data'));
    }
}
