<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Contracts;

use DateTimeImmutable;

interface OAuthAuthenticator extends Authenticator
{
    /**
     * @return string
     */
    public function getAccessToken(): string;

    /**
     * @return string|null
     */
    public function getRefreshToken(): ?string;

    /**
     * @return \DateTimeImmutable|null
     */
    public function getExpiresAt(): ?DateTimeImmutable;

    /**
     * @return bool
     */
    public function hasExpired(): bool;

    /**
     * @return bool
     */
    public function hasNotExpired(): bool;

    /**
     * Check if the authenticator is refreshable
     *
     * @return bool
     */
    public function isRefreshable(): bool;

    /**
     * Check if the authenticator is not refreshable
     *
     * @return bool
     */
    public function isNotRefreshable(): bool;
}
