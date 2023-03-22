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

namespace Anystack\WPGuard\V001\Composer\Command;

use Anystack\WPGuard\V001\Composer\Composer;
use Anystack\WPGuard\V001\Symfony\Component\Console\Input\InputInterface;
use Anystack\WPGuard\V001\Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class AboutCommand extends BaseCommand
{
    protected function configure(): void
    {
        $this
            ->setName('about')
            ->setDescription('Shows a short information about Composer')
            ->setHelp(
                <<<EOT
<info>php composer.phar about</info>
EOT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $composerVersion = Composer::getVersion();

        $this->getIO()->write(
            <<<EOT
<info>Composer - Dependency Manager for PHP - version $composerVersion</info>
<comment>Composer is a dependency manager tracking local dependencies of your projects and libraries.
See https://getcomposer.org/ for more information.</comment>
EOT
        );

        return 0;
    }
}
