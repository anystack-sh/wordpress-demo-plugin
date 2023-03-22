<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product;

use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;

class DeleteProductRequest extends Request
{
    protected Method $method = Method::DELETE;

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->id;
    }

    public function __construct(protected string $id)
    {
    }
}
