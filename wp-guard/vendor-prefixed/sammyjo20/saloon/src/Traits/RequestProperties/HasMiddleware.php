<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Traits\RequestProperties;

use Anystack\WPGuard\V001\Saloon\Helpers\MiddlewarePipeline;
use Anystack\WPGuard\V001\Saloon\Contracts\MiddlewarePipeline as MiddlewarePipelineContract;

trait HasMiddleware
{
    /**
     * Middleware Pipeline
     *
     * @var \Anystack\WPGuard\V001\Saloon\Contracts\MiddlewarePipeline
     */
    protected MiddlewarePipelineContract $middlewarePipeline;

    /**
     * Access the middleware pipeline
     *
     * @return \Anystack\WPGuard\V001\Saloon\Contracts\MiddlewarePipeline
     */
    public function middleware(): MiddlewarePipelineContract
    {
        return $this->middlewarePipeline ??= new MiddlewarePipeline;
    }
}
