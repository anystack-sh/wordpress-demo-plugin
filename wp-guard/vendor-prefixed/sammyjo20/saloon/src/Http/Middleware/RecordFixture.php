<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Middleware;

use Anystack\WPGuard\V001\Saloon\Contracts\Response;
use Anystack\WPGuard\V001\Saloon\Http\Faking\Fixture;
use Anystack\WPGuard\V001\Saloon\Helpers\ResponseRecorder;
use Anystack\WPGuard\V001\Saloon\Contracts\ResponseMiddleware;

class RecordFixture implements ResponseMiddleware
{
    /**
     * The Fixture
     *
     * @var \Anystack\WPGuard\V001\Saloon\Http\Faking\Fixture
     */
    protected Fixture $fixture;

    /**
     * Constructor
     *
     * @param \Anystack\WPGuard\V001\Saloon\Http\Faking\Fixture $fixture
     */
    public function __construct(Fixture $fixture)
    {
        $this->fixture = $fixture;
    }

    /**
     * Store the response
     *
     * @param \Anystack\WPGuard\V001\Saloon\Contracts\Response $response
     * @return void
     * @throws \ANYSTACK_WP_GUARD_JsonException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\UnableToCreateDirectoryException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\UnableToCreateFileException
     */
    public function __invoke(Response $response): void
    {
        $this->fixture->store(
            ResponseRecorder::record($response)
        );
    }
}
