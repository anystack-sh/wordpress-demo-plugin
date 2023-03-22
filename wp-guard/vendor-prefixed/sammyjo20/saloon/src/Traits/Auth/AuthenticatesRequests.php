<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\Auth;

use Anystack\WPGuard\V001\Saloon\Contracts\Authenticator;
use Anystack\WPGuard\V001\Saloon\Http\Auth\BasicAuthenticator;
use Anystack\WPGuard\V001\Saloon\Http\Auth\QueryAuthenticator;
use Anystack\WPGuard\V001\Saloon\Http\Auth\TokenAuthenticator;
use Anystack\WPGuard\V001\Saloon\Http\Auth\DigestAuthenticator;

trait AuthenticatesRequests
{
    /**
     * The authenticator used in requests.
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\Authenticator|null
     */
    protected ?Authenticator $authenticator = null;

    /**
     * Default authenticator used.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Authenticator|null
     */
    protected function defaultAuth(): ?Authenticator
    {
        return null;
    }

    /**
     * Retrieve the authenticator.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\Authenticator|null
     */
    public function getAuthenticator(): ?Authenticator
    {
        return $this->authenticator ?? $this->defaultAuth();
    }

    /**
     * Authenticate the request with an authenticator.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Authenticator $authenticator
     * @return $this
     */
    public function authenticate(Authenticator $authenticator): static
    {
        $this->authenticator = $authenticator;

        return $this;
    }

    /**
     * Authenticate the request with an Authorization header.
     *
     * @param string $token
     * @param string $prefix
     * @return $this
     */
    public function withTokenAuth(string $token, string $prefix = 'Bearer'): static
    {
        return $this->authenticate(new TokenAuthenticator($token, $prefix));
    }

    /**
     * Authenticate the request with "basic" authentication.
     *
     * @param string $username
     * @param string $password
     * @return $this
     */
    public function withBasicAuth(string $username, string $password): static
    {
        return $this->authenticate(new BasicAuthenticator($username, $password));
    }

    /**
     * Authenticate the request with "digest" authentication.
     *
     * @param string $username
     * @param string $password
     * @param string $digest
     * @return $this
     */
    public function withDigestAuth(string $username, string $password, string $digest): static
    {
        return $this->authenticate(new DigestAuthenticator($username, $password, $digest));
    }

    /**
     * Authenticate the request with a query parameter token.
     *
     * @param string $parameter
     * @param string $value
     * @return $this
     */
    public function withQueryAuth(string $parameter, string $value): static
    {
        return $this->authenticate(new QueryAuthenticator($parameter, $value));
    }
}
