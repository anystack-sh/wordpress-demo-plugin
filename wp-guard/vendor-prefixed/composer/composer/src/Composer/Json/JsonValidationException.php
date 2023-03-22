<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */ declare(strict_types=1);

/*
 * This file is part of Composer.
 *
 * (c) Nils Adermann <naderman@naderman.de>
 *     Jordi Boggiano <j.boggiano@seld.be>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 */

namespace Anystack\WPGuard\V001\Composer\Json;

use Exception;

/**
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class JsonValidationException extends Exception
{
    /**
     * @var string[]
     */
    protected $errors;

    /**
     * @param string[] $errors
     */
    public function __construct(string $message, array $errors = [], ?Exception $previous = null)
    {
        $this->errors = $errors;
        parent::__construct((string) $message, 0, $previous);
    }

    /**
     * @return string[]
     */
    public function getErrors(): array
    {
        return $this->errors;
    }
}
