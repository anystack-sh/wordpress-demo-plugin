<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product;

use Anystack\WPGuard\V001\Anystack\Sdk\Objects\Product;
use Anystack\WPGuard\V001\Saloon\Contracts\Body\HasBody;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;
use Anystack\WPGuard\V001\Saloon\Traits\Body\HasJsonBody;

class CreateProductRequest extends Request implements HasBody
{
    use HasJsonBody;

    protected Method $method = Method::POST;

    public function resolveEndpoint(): string
    {
        return '/products';
    }

    public function __construct(protected array $params)
    {
    }

    protected function defaultBody(): array
    {
        return $this->params;
    }

    public function createDtoFromResponse(Response $response): Product
    {
        return Product::fromResponse($response);
    }
}
