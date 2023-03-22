<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Connector;

use Anystack\WPGuard\V001\Saloon\Helpers\Config;
use Anystack\WPGuard\V001\Saloon\Contracts\Sender;

trait HasSender
{
    /**
     * Specify the default sender
     *
     * @var string
     */
    protected string $defaultSender = '';

    /**
     * The request sender.
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\Sender
     */
    protected Sender $sender;

    /**
     * Manage the request sender.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Sender
     */
    public function sender(): Sender
    {
        return $this->sender ??= $this->defaultSender();
    }

    /**
     * Define the default request sender.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Sender
     */
    protected function defaultSender(): Sender
    {
        if (empty($this->defaultSender)) {
            return Config::getDefaultSender();
        }

        return new $this->defaultSender;
    }
}
