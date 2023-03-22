<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Activation;

use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;

class UpdateActivationRequest extends Request
{
    protected Method $method = Method::PATCH;

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->productId.'/licenses/'.$this->licenseId.'/activations/'.$this->activationId;
    }

    public function __construct(protected string $productId, protected string $licenseId, protected string $activationId, protected array $parameters = [])
    {
    }

    protected function defaultBody(): array
    {
        return $this->parameters;
    }
}
