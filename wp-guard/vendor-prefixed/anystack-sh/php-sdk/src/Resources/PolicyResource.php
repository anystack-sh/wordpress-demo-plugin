<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Policy\DeletePolicyRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Policy\GetPolicyRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Policy\UpdatePolicyRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class PolicyResource extends Resource
{
    public function get(): Response
    {
        return $this->connector->send(new GetPolicyRequest($this->productId, $this->policyId));
    }

    public function update(array $parameters): Response
    {
        return $this->connector->send(new UpdatePolicyRequest($this->productId, $this->policyId, $parameters));
    }

    public function delete(): Response
    {
        return $this->connector->send(new DeletePolicyRequest($this->productId, $this->policyId));
    }
}
