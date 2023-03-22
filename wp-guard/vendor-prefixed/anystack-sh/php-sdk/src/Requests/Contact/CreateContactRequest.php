<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact;

use Anystack\WPGuard\V001\Saloon\Contracts\Body\HasBody;
use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;
use Anystack\WPGuard\V001\Saloon\Traits\Body\HasJsonBody;

class CreateContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/contacts';
    }

    public function __construct(protected array $params)
    {
    }

    protected function defaultBody(): array
    {
        return $this->params;
    }
}
