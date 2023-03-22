<?php
/**
 * @license MIT
 *
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\League\Flysystem\Plugin;

use Anystack\WPGuard\V001\League\Flysystem\FileExistsException;
use Anystack\WPGuard\V001\League\Flysystem\FileNotFoundException;

class ForcedCopy extends AbstractPlugin
{
    /**
     * @inheritdoc
     */
    public function getMethod()
    {
        return 'forceCopy';
    }

    /**
     * Copies a file, overwriting any existing files.
     *
     * @param string $path    Path to the existing file.
     * @param string $newpath The new path of the file.
     *
     * @throws FileExistsException
     * @throws FileNotFoundException Thrown if $path does not exist.
     *
     * @return bool True on success, false on failure.
     */
    public function handle($path, $newpath)
    {
        try {
            $deleted = $this->filesystem->delete($newpath);
        } catch (FileNotFoundException $e) {
            // The destination path does not exist. That's ok.
            $deleted = true;
        }

        if ($deleted) {
            return $this->filesystem->copy($path, $newpath);
        }

        return false;
    }
}
