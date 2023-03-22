<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Requests\Policy;

use Anystack\WPGuard\V001\Anystack\Sdk\Objects\Policy;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Enums\Method;
use Anystack\WPGuard\V001\Saloon\Http\Request;

class GetPolicyRequest extends Request
{
    protected Method $method = Method::GET;

    public function resolveEndpoint(): string
    {
        return '/products/'.$this->productId.'/policies/'.$this->policyId;
    }

    public function __construct(protected string $productId, protected string $policyId)
    {
    }

    public function createDtoFromResponse(Response $response): Policy
    {
        return Policy::fromResponse($response);
    }
}
