<?php

namespace Netsells\AttributeFinder;

use Generator;
use Netsells\AttributeFinder\Exceptions\InvalidDirectoryException;
use ReflectionClass;
use Symfony\Component\Finder\Finder;

class AttributeFinder
{
    private Finder $finder;
    private ClassNameResolver $classNameResolver;

    /**
     * @throws string InvalidDirectoryException
     */
    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            throw new InvalidDirectoryException("{$directory} is not a valid directory");
        }

        $this->finder = (new Finder())->in($directory)->files()->name('*.php');
        $this->classNameResolver = new ClassNameResolver($directory);
    }

    /**
     * @return iterable<ReflectionClass>
     */
    public function getClassesWithAttribute(string $attribute): iterable
    {
        foreach ($this->finder as $file) {
            $reflector = new ReflectionClass($this->classNameResolver->getClassFromPath($file));

            if ($reflector->getAttributes($attribute)) {
                yield $reflector;
            }
        }
    }
}
