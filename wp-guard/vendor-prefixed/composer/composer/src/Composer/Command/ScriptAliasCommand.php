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

use Anystack\WPGuard\V001\Composer\Pcre\Preg;
use Anystack\WPGuard\V001\Symfony\Component\Console\Input\InputInterface;
use Anystack\WPGuard\V001\Composer\Console\Input\InputOption;
use Anystack\WPGuard\V001\Composer\Console\Input\InputArgument;
use Anystack\WPGuard\V001\Symfony\Component\Console\Output\OutputInterface;

/**
 * @author Jordi Boggiano <j.boggiano@seld.be>
 */
class ScriptAliasCommand extends BaseCommand
{
    /** @var string */
    private $script;
    /** @var string */
    private $description;

    public function __construct(string $script, ?string $description)
    {
        $this->script = $script;
        $this->description = $description ?? 'Runs the '.$script.' script as defined in composer.json';

        $this->ignoreValidationErrors();

        parent::__construct();
    }

    protected function configure(): void
    {
        $this
            ->setName($this->script)
            ->setDescription($this->description)
            ->setDefinition([
                new InputOption('dev', null, InputOption::VALUE_NONE, 'Sets the dev mode.'),
                new InputOption('no-dev', null, InputOption::VALUE_NONE, 'Disables the dev mode.'),
                new InputArgument('args', InputArgument::IS_ARRAY | InputArgument::OPTIONAL, ''),
            ])
            ->setHelp(
                <<<EOT
The <info>run-script</info> command runs scripts defined in composer.json:

<info>php composer.phar run-script post-update-cmd</info>

Read more at https://getcomposer.org/doc/03-cli.md#run-script-run
EOT
            )
        ;
    }

    protected function execute(InputInterface $input, OutputInterface $output): int
    {
        $composer = $this->requireComposer();

        $args = $input->getArguments();

        // TODO remove for Symfony 6+ as it is then in the interface
        if (!method_exists($input, '__toString')) { // @phpstan-ignore-line
            throw new \LogicException('Expected an Input instance that is stringable, got '.get_class($input));
        }

        return $composer->getEventDispatcher()->dispatchScript($this->script, $input->getOption('dev') || !$input->getOption('no-dev'), $args['args'], ['script-alias-input' => Preg::replace('{^\S+ ?}', '', $input->__toString(), 1)]);
    }
}
