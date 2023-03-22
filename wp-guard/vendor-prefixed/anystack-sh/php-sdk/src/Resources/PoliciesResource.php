<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Policy\GetPoliciesRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Policy\GetPolicyRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class PoliciesResource extends Resource
{
    public function all(int $page = 1): Response
    {
        return $this->connector->send(new GetPoliciesRequest($this->productId, $page));
    }

    public function get(string $policyId): Response
    {
        return $this->connector->send(new GetPolicyRequest($this->productId, $policyId));
    }
}
