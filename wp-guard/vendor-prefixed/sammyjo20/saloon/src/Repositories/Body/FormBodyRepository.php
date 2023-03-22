<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Repositories\Body;

class FormBodyRepository extends ArrayBodyRepository
{
    /**
     * Convert into a string.
     *
     * @return string
     */
    public function __toString(): string
    {
        return http_build_query($this->all());
    }
}
