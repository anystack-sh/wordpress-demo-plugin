<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Body;

use Anystack\WPGuard\V001\Saloon\Repositories\Body\StringBodyRepository;

trait HasBody
{
    use ChecksForHasBody;

    /**
     * Body Repository
     *
     * @var \Anystack\WPGuard\V001\Saloon\Repositories\Body\StringBodyRepository
     */
    protected StringBodyRepository $body;

    /**
     * Retrieve the data repository
     *
     * @return \Anystack\WPGuard\V001\Saloon\Repositories\Body\StringBodyRepository
     */
    public function body(): StringBodyRepository
    {
        return $this->body ??= new StringBodyRepository($this->defaultBody());
    }

    /**
     * Default body
     *
     * @return string|null
     */
    protected function defaultBody(): ?string
    {
        return null;
    }
}
