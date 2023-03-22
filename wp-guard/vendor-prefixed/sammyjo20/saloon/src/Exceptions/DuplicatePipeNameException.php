<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Exceptions;

class DuplicatePipeNameException extends SaloonException
{
    /**
     * Constructor
     *
     * @param string $name
     */
    public function __construct(string $name)
    {
        parent::__construct(sprintf('The "%s" pipe already exists on the pipeline', $name));
    }
}
