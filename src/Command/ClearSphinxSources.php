<?php

declare(strict_types=1);

namespace App\Command;

use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;

class ClearSphinxSources extends Command
{
    private string $contextFilesPath;
    private string $indexFilePath;
    private Filesystem $filesystem;

    public function __construct(string $contextFilesPath, string $indexFilePath, Filesystem $filesystem)
    {
        parent::__construct('app:docs:sphinx-clear');
        $this->contextFilesPath = $contextFilesPath;
        $this->indexFilePath = $indexFilePath;
        $this->filesystem = $filesystem;
    }

    protected function execute(InputInterface $input, OutputInterface $output)
    {
        $this->filesystem->remove($this->contextFilesPath);
        $this->filesystem->remove($this->indexFilePath);

        return Command::SUCCESS;
    }
}