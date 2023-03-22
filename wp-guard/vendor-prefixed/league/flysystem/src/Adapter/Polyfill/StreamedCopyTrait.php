<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\League\Flysystem\Adapter\Polyfill;

use Anystack\WPGuard\V001\League\Flysystem\Config;

trait StreamedCopyTrait
{
    /**
     * Copy a file.
     *
     * @param string $path
     * @param string $newpath
     *
     * @return bool
     */
    public function copy($path, $newpath)
    {
        $response = $this->readStream($path);

        if ($response === false || ! is_resource($response['stream'])) {
            return false;
        }

        $result = $this->writeStream($newpath, $response['stream'], new Config());

        if ($result !== false && is_resource($response['stream'])) {
            fclose($response['stream']);
        }

        return $result !== false;
    }

    // Required abstract method

    /**
     * @param string $path
     *
     * @return resource
     */
    abstract public function readStream($path);

    /**
     * @param string   $path
     * @param resource $resource
     * @param Config   $config
     *
     * @return resource
     */
    abstract public function writeStream($path, $resource, Config $config);
}
