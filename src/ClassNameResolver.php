<?php

namespace Netsells\AttributeFinder;

use Netsells\AttributeFinder\Exceptions\InvalidDirectoryException;

class ClassNameResolver
{
    private ?string $rootNamespace = null;
    private string $directory;

    /**
     * @throws string InvalidDirectoryException
     */
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

        // remove actual class file name and convert forward slashed into backslashes
        $explodedPathDiff = explode('/', $pathDiff);
        array_pop($explodedPathDiff);
        $namespaceDiff = implode('\\', $explodedPathDiff);

        // Remove the namespace diff from the full class namespace to leave the root namespace
        $this->rootNamespace = trim(str_replace($namespaceDiff, '', $namespace), '\\');
    }

    private function getNamespaceFromPath(string $path): string
    {
        //Need to convert Windows line endings to proper ones
        $fileSource = str_replace("\r\n", "\r", file_get_contents($path));

        preg_match('#^namespace\s+(.+?);$#sm', $fileSource, $matches);

        // get class namespace
        return $matches[1] . '\\';
    }

    private function getClassName(string $path): string
    {
        // replace the root directory with the root namespace - assumes PSR4
        $className = str_replace($this->directory, $this->rootNamespace, $path);

        $className = str_replace('/', '\\', $className);

        // replace the file name with the class name
        return str_replace(basename($path), basename($path, '.php'), $className);
    }
}
