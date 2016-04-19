<?php

namespace App\Bundle\GamificationCoreBundle;

use ReflectionClass;
use Symfony\Component\Finder\Finder;
use Symfony\Component\HttpFoundation\File\File;
use Symfony\Component\HttpKernel\Bundle\Bundle;
use Symfony\Component\Console\Application;

class GamificationCoreBundle extends Bundle
{
    public function registerCommands(Application $application)
    {
        parent::registerCommands($application);
        $this->registerCustomGamificationCommands($application);
    }

    /**
     * @param Application $application
     */
    private function registerCustomGamificationCommands($application)
    {
        $rootPath = $this->container->getParameter('kernel.root_dir');
        $finder = $this->locateCommandFiles($rootPath);

        foreach ($finder as $file) {
            $commandClassName = $this->commandClassName($rootPath, $file);
            $reflectedCommand = new ReflectionClass($commandClassName);
            $application->add($reflectedCommand->newInstance());
        }
    }

    /**
     * @param string $rootPath
     * @return Finder
     */
    private function locateCommandFiles($rootPath)
    {
        $finder = Finder::create();
        $finder
            ->files()
            ->in([
                $rootPath . '/../src/App/Command/GammificationCommand',
            ])
            ->name('*Command.php');

        return $finder;
    }

    /**
     * @param string $rootPath
     * @param File $file
     *
     * @return mixed
     */
    private function commandClassName($rootPath, $file)
    {
        return str_replace(
            [
                realpath($rootPath . '/../src') . '/',
                '.php',
                DIRECTORY_SEPARATOR
            ],
            [
                '',
                '',
                '\\'
            ],
            $file->getRealPath()
        );
    }
}
