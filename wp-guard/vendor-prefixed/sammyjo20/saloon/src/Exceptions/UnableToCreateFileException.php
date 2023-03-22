<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Exceptions;

class UnableToCreateFileException extends SaloonException
{
    /**
     * Constructor
     *
     * @param string $path
     */
    public function __construct(string $path)
    {
        parent::__construct(sprintf('We were unable to create the "%s" file.', $path));
    }
}
