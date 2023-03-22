<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Contact;

use Anystack\WPGuard\V001\Anystack\Sdk\Objects\Contact;
use Anystack\WPGuard\V001\Saloon\Contracts\Body\HasBody;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;
use Anystack\WPGuard\V001\Saloon\Traits\Body\HasJsonBody;

class UpdateContactRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::PATCH;

    public function resolveEndpoint(): string
    {
        return '/contacts/'.$this->contactId;
    }

    public function __construct(protected string $contactId, protected array $parameters = [])
    {
    }

    protected function defaultBody(): array
    {
        return $this->parameters;
    }

    public function createDtoFromResponse(Response $response): Contact
    {
        return Contact::fromResponse($response);
    }
}
