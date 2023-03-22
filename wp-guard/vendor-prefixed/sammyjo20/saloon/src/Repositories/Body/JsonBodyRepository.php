<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Repositories\Body;

class JsonBodyRepository extends ArrayBodyRepository
{
    /**
     * Convert the body repository into a string.
     *
     * @return string
     * @throws \ANYSTACK_WP_GUARD_JsonException
     */
    public function __toString(): string
    {
        return json_encode($this->all(), JSON_THROW_ON_ERROR);
    }
}
