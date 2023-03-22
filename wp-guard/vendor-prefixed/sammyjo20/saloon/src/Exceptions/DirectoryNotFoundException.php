<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Exceptions;

class DirectoryNotFoundException extends SaloonException
{
    /**
     * Constructor
     *
     * @param string $directory
     */
    public function __construct(string $directory)
    {
        parent::__construct(sprintf('The directory "%s" does not exist or is not a valid directory.', $directory));
    }
}
