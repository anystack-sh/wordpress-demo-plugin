<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts\Body;

interface HasBody
{
    /**
     * Define Data
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Body\BodyRepository
     */
    public function body(): BodyRepository;
}
