<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\BrianHenryIE\Strauss\Console;

use Anystack\WPGuard\V001\BrianHenryIE\Strauss\Console\Commands\Compose;
use Anystack\WPGuard\V001\Symfony\Component\Console\Application as BaseApplication;

class Application extends BaseApplication
{
    /**
     * @param string $version
     */
    public function __construct(string $version)
    {
        parent::__construct('strauss', $version);

        $composeCommand = new Compose();
        $this->add($composeCommand);

        $this->setDefaultCommand('compose');
    }
}
