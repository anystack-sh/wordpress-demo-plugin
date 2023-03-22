<?php
/**
 * Deletes source files and empty directories.
 *
 * @license MIT
 * Modified by Philo Hermans on 21-March-2023 using Strauss.
 * @see https://github.com/BrianHenryIE/strauss
 */

namespace Anystack\WPGuard\V001\BrianHenryIE\Strauss;

use Anystack\WPGuard\V001\BrianHenryIE\Strauss\Composer\Extra\StraussConfig;
use Anystack\WPGuard\V001\League\Flysystem\Adapter\Local;
use Anystack\WPGuard\V001\League\Flysystem\Filesystem;
use RecursiveDirectoryIterator;
use Anystack\WPGuard\V001\Symfony\Component\Finder\Finder;

class Cleanup
{

    /** @var Filesystem */
    protected Filesystem $filesystem;

    protected bool $isDeleteVendorFiles;

    protected string $vendorDirectory = 'vendor'. DIRECTORY_SEPARATOR;
    
    public function __construct(StraussConfig $config, string $workingDir)
    {
        $this->vendorDirectory = $config->getVendorDirectory();

        $this->isDeleteVendorFiles = $config->isDeleteVendorFiles();
        
        $this->filesystem = new Filesystem(new Local($workingDir));
    }

    /**
     * Maybe delete the source files that were copied (depending on config),
     * then delete empty directories.
     *
     * @param array $sourceFiles
     */
    public function cleanup(array $sourceFiles)
    {

        // TODO Don't do this if vendor is the target dir (i.e. in-situ updating).

        if ($this->isDeleteVendorFiles) {
            foreach ($sourceFiles as $sourceFile) {
                $relativeFilepath = $this->vendorDirectory . $sourceFile;

                $this->filesystem->delete($relativeFilepath);
            }

            // Get the root folders of the moved files.
            $rootSourceDirectories = [];
            foreach ($sourceFiles as $sourceFile) {
                $arr = explode("/", $sourceFile, 2);
                $dir = $arr[0];
                $rootSourceDirectories[ $dir ] = $dir;
            }
            $rootSourceDirectories = array_keys($rootSourceDirectories);


            $finder = new Finder();

            foreach ($rootSourceDirectories as $rootSourceDirectory) {
                if (!is_dir($rootSourceDirectory) || is_link($rootSourceDirectory)) {
                    continue;
                }

                $finder->directories()->path($rootSourceDirectory);

                foreach ($finder as $directory) {
                    $metadata = $this->filesystem->getMetadata($directory);

                    if ($this->dirIsEmpty($directory)) {
                        $this->filesystem->deleteDir($directory);
                    }
                }
            }
        }
    }

    // TODO: Use Symphony or Flysystem functions.
    protected function dirIsEmpty(string $dir): bool
    {
        $di = new RecursiveDirectoryIterator($dir, \FilesystemIterator::SKIP_DOTS);
        return iterator_count($di) === 0;
    }
}
