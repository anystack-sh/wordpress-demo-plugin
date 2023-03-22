<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\OAuth2;

use Anystack\WPGuard\V001\Saloon\Helpers\OAuth2\OAuthConfig;

trait HasOAuthConfig
{
    /**
     * The OAuth2 Config
     *
     * @var \Anystack\WPGuard\V001\Saloon\Helpers\OAuth2\OAuthConfig
     */
    protected OAuthConfig $oauthConfig;

    /**
     * Manage the OAuth2 config
     *
     * @return \Anystack\WPGuard\V001\Saloon\Helpers\OAuth2\OAuthConfig
     */
    public function oauthConfig(): OAuthConfig
    {
        return $this->oauthConfig ??= $this->defaultOauthConfig();
    }

    /**
     * Define the default Oauth 2 Config.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Helpers\OAuth2\OAuthConfig
     */
    protected function defaultOauthConfig(): OAuthConfig
    {
        return OAuthConfig::make();
    }
}
