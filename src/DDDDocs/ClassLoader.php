<?php

declare(strict_types=1);

namespace App\DDDDocs;

use Nette\Loaders\RobotLoader;

class ClassLoader
{
    private RobotLoader $robotLoader;
    private string $contextsPath;
    private string $tmpDirectory;
    private array $classes = [];

    public function __construct(RobotLoader $robotLoader, string $contextsPath, string $tmpDirectory)
    {
        $this->robotLoader = $robotLoader;
        $this->contextsPath = $contextsPath;
        $this->tmpDirectory = $tmpDirectory;
    }

    public function load(): array
    {
        if (empty($this->classes)) {
            $this->robotLoader->addDirectory($this->contextsPath);
            $this->robotLoader->setTempDirectory($this->tmpDirectory);
            $this->robotLoader->register();

            $this->classes = array_keys($this->robotLoader->getIndexedClasses());
        }

        return $this->classes;
    }
}