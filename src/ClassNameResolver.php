<?php

namespace Netsells\AttributeFinder;

use Netsells\AttributeFinder\Exceptions\InvalidDirectoryException;

class ClassNameResolver
{
    private ?string $rootNamespace = null;
    private string $directory;

    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            throw new InvalidDirectoryException("{$directory} is not a valid directory");
        }

        $this->directory = $directory;
    }

    public function getClassFromPath(string $path): string
    {
        if ($this->rootNamespace === null) {
            $this->setRootNamespace($path);
        }

        return $this->getClassName($path);
    }

    private function setRootNamespace(string $path): void
    {
        // get class namespace
        $namespace = $this->getNamespaceFromPath($path);

        // get diff between directory and path
        $pathDiff =  str_replace($this->directory, '', $path);

        // remove actual class name
        $explodedPathDiff = explode('/', $pathDiff);
        array_pop($explodedPathDiff);

        $namespaceDiff = implode('\\', $explodedPathDiff);

        $this->rootNamespace = trim(str_replace($namespaceDiff, '', $namespace), '\\');
    }

    private function getNamespaceFromPath(string $path): string
    {
        $fileSource = file_get_contents($path);

        preg_match('#^namespace\s+(.+?);$#sm', $fileSource, $matches);

        // get class namespace
        return $matches[1] . '\\';
    }

    private function getClassName(string $path): string
    {
        $string = str_replace($this->directory, $this->rootNamespace, $path);

        $string = str_replace('/', '\\', $string);

        return str_replace(basename($path), basename($path, '.php'), $string);
    }
}
