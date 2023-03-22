<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk;

use Anystack\WPGuard\V001\Anystack\Sdk\Exceptions\ValidationException;
use Anystack\WPGuard\V001\Anystack\Sdk\Resources\ContactResource;
use Anystack\WPGuard\V001\Anystack\Sdk\Resources\ContactsResource;
use Anystack\WPGuard\V001\Anystack\Sdk\Resources\ProductResource;
use Anystack\WPGuard\V001\Anystack\Sdk\Resources\ProductsResource;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Http\Connector;
use Anystack\WPGuard\V001\Saloon\Traits\Plugins\AlwaysThrowOnErrors;

class AnystackApi extends Connector
{
    use AlwaysThrowOnErrors;

    public function resolveBaseUrl(): string
    {
        return 'https://api.anystack.sh/v1';
    }

    public function __construct(protected string $apiToken)
    {
        $this->withTokenAuth($this->apiToken);
    }

    protected function defaultHeaders(): array
    {
        return [
            'Content-Type' => 'application/json',
            'Accept' => 'application/json',
        ];
    }

    public function getRequestException(Response $response, ?\Throwable $senderException): ?\Throwable
    {
        return (new ValidationException($response->json('message')))->setErrors($response->json('errors'));
    }

    public function contacts(): ContactsResource
    {
        return new ContactsResource($this);
    }

    public function contact(string $id): ContactResource
    {
        return new ContactResource($this);
    }

    public function products(): ProductsResource
    {
        return new ProductsResource($this);
    }

    public function product(string $id): ProductResource
    {
        return new ProductResource(connector: $this, productId: $id);
    }
}
