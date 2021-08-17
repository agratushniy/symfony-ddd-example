<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ClearClassLoaderCache extends \Symfony\Component\Console\Command\Command
{
    private string $cachePath;
    private Filesystem $filesystem;

    public function __construct(string $cachePath, Filesystem $filesystem)
    {
        parent::__construct('app:docs:classLoader:cache-clear');
        $this->cachePath = $cachePath;
        $this->filesystem = $filesystem;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->filesystem->remove($this->cachePath);

        return Command::SUCCESS;
    }
}