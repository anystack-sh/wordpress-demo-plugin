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

class Release implements WithResponse
{
    use HasResponse;

    public function __construct(
        public string $id,
        public string $tag,
        public bool $draft,
        public string $description,
        public bool $prerelease,
        public string $createdAt,
        public string $updatedAt,
        public array $links,
        public ?string $publishedAt = null,
    ) {
    }

    public static function fromArray(array $data): self
    {
        return new static(
            id: $data['id'],
            tag: $data['tag'],
            draft: $data['draft'],
            description: $data['description'],
            prerelease: $data['prerelease'],
            createdAt: $data['created_at'],
            updatedAt: $data['updated_at'],
            links: $data['links'],
            publishedAt: $data['published_at'],
        );
    }

    public static function fromResponse(Response $response): self
    {
        return static::fromArray($response->json('data'));
    }
}
