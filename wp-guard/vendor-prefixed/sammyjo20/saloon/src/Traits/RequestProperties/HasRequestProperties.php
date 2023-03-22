<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\RequestProperties;

trait HasRequestProperties
{
    use HasHeaders;
    use HasQuery;
    use HasConfig;
    use HasMiddleware;
    use HasDelay;
}
