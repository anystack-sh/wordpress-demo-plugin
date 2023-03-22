<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Objects;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class PolicyCollection
{
    public function __construct(public array $items = [])
    {
    }

    public static function fromResponse(Response $response): self
    {
        return new static(
            array_map(function ($release) {
                return Policy::fromArray($release);
            }, $response->json('data'))
        );
    }
}
