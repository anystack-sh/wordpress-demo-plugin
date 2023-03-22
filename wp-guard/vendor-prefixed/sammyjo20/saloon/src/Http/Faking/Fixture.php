<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\Saloon\Http\Faking;

use Anystack\WPGuard\V001\Saloon\Helpers\Storage;
use Anystack\WPGuard\V001\Saloon\Helpers\MockConfig;
use Anystack\WPGuard\V001\Saloon\Data\RecordedResponse;
use Anystack\WPGuard\V001\Saloon\Exceptions\FixtureMissingException;

class Fixture
{
    /**
     * The extension used by the fixture
     *
     * @var string
     */
    protected static string $fixtureExtension = 'json';

    /**
     * The name of the fixture
     *
     * @var string
     */
    protected string $name;

    /**
     * The storage helper
     *
     * @var \Anystack\WPGuard\V001\Saloon\Helpers\Storage
     */
    protected Storage $storage;

    /**
     * Constructor
     *
     * @param string $name
     * @param \Anystack\WPGuard\V001\Saloon\Helpers\Storage|null $storage
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\DirectoryNotFoundException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\UnableToCreateDirectoryException
     */
    public function __construct(string $name, Storage $storage = null)
    {
        $this->name = $name;
        $this->storage = $storage ?? new Storage(MockConfig::getFixturePath(), true);
    }

    /**
     * Attempt to get the mock response from the fixture.
     *
     * @return \Anystack\WPGuard\V001\Saloon\Http\Faking\MockResponse|null
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\FixtureMissingException
     * @throws \ANYSTACK_WP_GUARD_JsonException
     */
    public function getMockResponse(): ?MockResponse
    {
        $storage = $this->storage;
        $fixturePath = $this->getFixturePath();

        if ($storage->exists($fixturePath)) {
            return RecordedResponse::fromFile($storage->get($fixturePath))->toMockResponse();
        }

        if (MockConfig::isThrowingOnMissingFixtures() === true) {
            throw new FixtureMissingException($fixturePath);
        }

        return null;
    }

    /**
     * Store data as the fixture.
     *
     * @param \Anystack\WPGuard\V001\Saloon\Data\RecordedResponse $recordedResponse
     * @return $this
     * @throws \ANYSTACK_WP_GUARD_JsonException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\UnableToCreateDirectoryException
     * @throws \Anystack\WPGuard\V001\Saloon\Exceptions\UnableToCreateFileException
     */
    public function store(RecordedResponse $recordedResponse): static
    {
        $this->storage->put($this->getFixturePath(), $recordedResponse->toFile());

        return $this;
    }

    /**
     * Get the fixture path
     *
     * @return string
     */
    public function getFixturePath(): string
    {
        return sprintf('%s.%s', $this->name, $this::$fixtureExtension);
    }
}
