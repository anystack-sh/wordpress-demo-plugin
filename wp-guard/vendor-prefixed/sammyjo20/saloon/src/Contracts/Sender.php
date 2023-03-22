<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

use Anystack\WPGuard\V001\GuzzleHttp\Promise\PromiseInterface;

interface Sender
{
    /**
     * Send the request.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\PendingRequest $pendingRequest
     * @param bool $asynchronous
     * @return ($asynchronous is true ? \Anystack\WPGuard\V001\Saloon\Contracts\Response|PromiseInterface : \Anystack\WPGuard\V001\Saloon\Contracts\Response)
     */
    public function sendRequest(PendingRequest $pendingRequest, bool $asynchronous = false): Response|PromiseInterface;
}
