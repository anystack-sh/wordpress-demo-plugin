<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

declare(strict_types=1);

namespace Anystack\WPGuard\V001\JsonMapper\Middleware\Rename;

use Anystack\WPGuard\V001\JsonMapper\JsonMapperInterface;
use Anystack\WPGuard\V001\JsonMapper\Middleware\AbstractMiddleware;
use Anystack\WPGuard\V001\JsonMapper\ValueObjects\PropertyMap;
use Anystack\WPGuard\V001\JsonMapper\Wrapper\ObjectWrapper;

class Rename extends AbstractMiddleware
{
    /** @var Mapping[] */
    private $mapping;

    public function __construct(Mapping ...$mapping)
    {
        $this->mapping = $mapping;
    }

    public function addMapping(string $class, string $from, string $to): void
    {
        $this->mapping[] = new Mapping($class, $from, $to);
    }

    public function handle(
        \stdClass $json,
        ObjectWrapper $object,
        PropertyMap $propertyMap,
        JsonMapperInterface $mapper
    ): void {
        $mapping = \array_filter($this->mapping, static function ($map) use ($object) {
            return $map->getClass() === $object->getName();
        });
        foreach ($mapping as $map) {
            $from = $map->getFrom();
            $to = $map->getTo();

            if (isset($json->$from)) {
                $json->$to = $json->$from;
                unset($json->$from);
            }
        }
    }
}
