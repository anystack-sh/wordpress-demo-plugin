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

class GetUserRequest extends Request implements HasBody
{
    use HasFormBody;
    use AcceptsJson;

    /**
     * Define the method that the request will use.
     *
     * @var \Anystack\WPGuard\V001\Saloon\Enums\Method
     */
    protected Method $method = Method::GET;

    /**
     * Define the endpoint for the request.
     *
     * @return string
     */
    public function resolveEndpoint(): string
    {
        return $this->oauthConfig->getUserEndpoint();
    }

    /**
     * Requires the authorization code and OAuth 2 config.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Helpers\OAuth2\OAuthConfig $oauthConfig
     */
    public function __construct(protected OAuthConfig $oauthConfig)
    {
        //
    }
}
