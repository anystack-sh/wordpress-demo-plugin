<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\Anystack\Sdk\Resources;

use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product\CreateProductRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product\DeleteProductRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product\GetProductRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product\GetProductsRequest;
use Anystack\WPGuard\V001\Anystack\Sdk\Requests\Product\UpdateProductRequest;
use Anystack\WPGuard\V001\Saloon\Contracts\Response;

class ProductsResource extends Resource
{
    public function all(int $page = 1): Response
    {
        return $this->connector->send(new GetProductsRequest($page));
    }

    public function get(string $productId): Response
    {
        return $this->connector->send(new GetProductRequest($productId));
    }

    public function create(array $parameters): Response
    {
        return $this->connector->send(new CreateProductRequest($parameters));
    }

    public function update(string $productId, array $parameters): Response
    {
        return $this->connector->send(new UpdateProductRequest($productId, $parameters));
    }

    public function delete(string $productId): Response
    {
        return $this->connector->send(new DeleteProductRequest($productId));
    }
}
