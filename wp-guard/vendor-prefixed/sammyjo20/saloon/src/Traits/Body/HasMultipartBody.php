<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Body;

use Anystack\WPGuard\V001\Saloon\Repositories\Body\MultipartBodyRepository;

trait HasMultipartBody
{
    use ChecksForHasBody;

    /**
     * Body Repository
     *
     * @var \Anystack\WPGuard\V001\Saloon\Repositories\Body\MultipartBodyRepository
     */
    protected MultipartBodyRepository $body;

    /**
     * Retrieve the data repository
     *
     * @return \Anystack\WPGuard\V001\Saloon\Repositories\Body\MultipartBodyRepository
     */
    public function body(): MultipartBodyRepository
    {
        return $this->body ??= new MultipartBodyRepository($this->defaultBody());
    }

    /**
     * Default body
     *
     * @return array<\Saloon\Data\MultipartValue>
     */
    protected function defaultBody(): array
    {
        return [];
    }
}
