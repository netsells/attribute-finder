<?php

namespace Netsells\AttributeFinder;

use Symfony\Component\Finder\Finder;

class AttributeFinder
{
    private Finder $finder;

    public function __construct(string $directory)
    {
        $this->finder = (new Finder())->in($directory)->files()->name('*.php');
    }

    public function getClassesWithAttribute(string $attribute): array
    {
        $classes = [];

        $files = $this->getClassPaths($attribute);

        foreach ($files as $file) {
            if ($class = $this->getClassFromPath($file)) {
                $classes[] = $class;
            }
        }

        return $classes;
    }

    private function getClassPaths(string $attribute): iterable
    {
        $explodedAttribute = explode('\\', $attribute);
        $className = array_pop($explodedAttribute);

        // Match fully qualified attribute aswell as attributes where arguments are and aren't passed
        return $this->finder->contains("/^\s*(\#\[(.*?)FiltersModel(\(.*?\))?\])/m");
    }

    private function getClassFromPath(string $path): ?string
    {
        $fileSource = file_get_contents($path);

        preg_match('#^namespace\s+(.+?);$#sm', $fileSource, $matches);

        if (!isset($matches[1])) {
            return null;
        }

        $namespace = $matches[1] . '\\';

        $class = $namespace . str_replace('.php', '', basename($path));

        return $class;
    }
}
