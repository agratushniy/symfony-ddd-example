<?php

declare(strict_types=1);

namespace App\Command;

use App\DDDDocs\ClassLoader;
use App\DDDDocs\ContextInfoGrabber;
use App\DDDDocs\Grabber\IGrabber;
use App\Kernel;
use JsonException;
use Laminas\Code\Reflection\ClassReflection;
use ReflectionException;
use RuntimeException;
use Symfony\Component\Console\Command\Command;
use Symfony\Component\Console\Input\InputInterface;
use Symfony\Component\Console\Output\OutputInterface;
use Symfony\Component\Filesystem\Filesystem;
use Twig\Environment;
use Twig\Error\LoaderError;
use Twig\Error\RuntimeError;
use Twig\Error\SyntaxError;

class GenerateDocs extends Command
{
    private Kernel $kernel;
    private Environment $twig;
    private ClassLoader $classesLoader;
    private ContextInfoGrabber $contextInfoGrabber;
    /**
     * @var iterable|IGrabber[]
     */
    private iterable $classGrabbers;
    private Filesystem $filesystem;
    private iterable $contextsList;

    public function __construct(
        Kernel $kernel,
        Environment $twig,
        ClassLoader $classesLoader,
        ContextInfoGrabber $contextInfoGrabber,
        Filesystem $filesystem,
        iterable $classGrabbers,
        iterable $contextsList
    ) {
        parent::__construct('app:docs:generate');
        $this->kernel = $kernel;
        $this->twig = $twig;
        $this->classesLoader = $classesLoader;
        $this->contextInfoGrabber = $contextInfoGrabber;
        $this->classGrabbers = $classGrabbers;
        $this->filesystem = $filesystem;
        $this->contextsList = $contextsList;
    }

    /**
     * @param InputInterface $input
     * @param OutputInterface $output
     * @return int
     * @throws JsonException
     * @throws ReflectionException
     * @throws LoaderError
     * @throws RuntimeError
     * @throws SyntaxError
     */
    protected function execute(InputInterface $input, OutputInterface $output)
    {
        ini_set('memory_limit', '-1');
        $classes = $this->classesLoader->load();

        $contextsData = [];

        foreach ($this->contextsList as $contextCode) {

            if (!$context = $this->contextInfoGrabber->getContextInfo($contextCode)) {
                continue;
            }

            foreach ($classes as $className) {
                $classReflection = new ClassReflection($className);

                foreach ($this->classGrabbers as $classGrabber) {
                    $classGrabber->grab($classReflection, $context);
                }
            }

            $contextsData[] = $context;
        }

        $buildPath = $this->kernel->getProjectDir() . '/resources/sphinx/source';


        $indexContent = $this->twig->render('_documentation/index.tpl.rst', ['contexts' => $contextsData]);
        $this->filesystem->dumpFile($buildPath . '/index.rst', $indexContent);

        foreach ($contextsData as $context) {
            $contextFolderPath = $buildPath . '/context/' . $context->code;

            if (!file_exists($contextFolderPath)) {
                if (!mkdir($contextFolderPath, 0755, true) && !is_dir($contextFolderPath)) {
                    throw new RuntimeException(sprintf('Directory "%s" was not created', $contextFolderPath));
                }
            }

            /*
             * Детальная страница контекста с оглавлением
             */
            $contextTpl = $this->twig->render('_documentation/context.index.tpl.rst', ['context' => $context]);
            $this->filesystem->dumpFile($contextFolderPath . '/index.rst', $contextTpl);

            /*
             * Детальные страницы сущностей
             */
            foreach ($context->entities() as $entity) {
                $entityDetailTpl = $this->twig->render('_documentation/entity_detail.tpl.rst',
                    ['context' => $context, 'entity' => $entity]);
                $abcDetailFilePath = sprintf('%s/abc_%s.rst', $contextFolderPath, $entity->code);
                $this->filesystem->dumpFile($abcDetailFilePath, $entityDetailTpl);
            }

            /*
             * Словарик
             */
            $abcTpl = $this->twig->render('_documentation/abc.tpl.rst', ['context' => $context]);
            $this->filesystem->dumpFile($contextFolderPath . '/abc.rst', $abcTpl);

            /*
             * Сценарии использования
             */
            $useCaseTpl = $this->twig->render('_documentation/use_case.tpl.rst', ['context' => $context]);
            $this->filesystem->dumpFile($contextFolderPath . '/scenarios.rst', $useCaseTpl);
        }

        return Command::SUCCESS;
    }
}