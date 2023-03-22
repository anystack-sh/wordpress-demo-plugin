<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\OAuth2;

use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;
use Anystack\WPGuard\V001\Saloon\Contracts\Body\HasBody;
use Anystack\WPGuard\V001\Saloon\Traits\Body\HasFormBody;
use Anystack\WPGuard\V001\Saloon\Helpers\OAuth2\OAuthConfig;
use Anystack\WPGuard\V001\Saloon\Traits\Plugins\AcceptsJson;

class GetRefreshTokenRequest extends Request implements HasBody
{
    use HasFormBody;
    use AcceptsJson;

    /**
     * Define the method that the request will use.
     *
     * @var \Anystack\WPGuard\V001\Saloon\Enums\Method
     */
    protected Method $method = Method::POST;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return $this->oauthConfig->getTokenEndpoint();
    }

    /**
     * Requires the authorization code and OAuth 2 config.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Helpers\OAuth2\OAuthConfig $oauthConfig
     * @param string $refreshToken
     */
    public function __construct(protected OAuthConfig $oauthConfig, protected string $refreshToken)
    {
        //
    }

    /**
     * Register the default data.
     *
     * @return array{
     *     grant_type: string,
     *     refresh_token: string,
     *     client_id: string,
     *     client_secret: string,
     * }
     */
    public function defaultBody(): array
    {
        return [
            'grant_type' => 'refresh_token',
            'refresh_token' => $this->refreshToken,
            'client_id' => $this->oauthConfig->getClientId(),
            'client_secret' => $this->oauthConfig->getClientSecret(),
        ];
    }
}
