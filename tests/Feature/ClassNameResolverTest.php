<?php

namespace Netsells\AttributeFinder\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Netsells\AttributeFinder\ClassNameResolver;

class ClassNameResolverTest extends TestCase
{
    public function testResolvesNamespaceFromPath()
    {
        $directory = __DIR__ . '/../TestFiles';
        $path = $directory . '/TestAttributeOne.php';
        $resolver = new ClassNameResolver($directory);

        $expected = 'Netsells\AttributeFinder\Tests\TestFiles\TestAttributeOne';

        $actual = $resolver->getClassFromPath($path);

        $this->assertEquals($expected, $actual);
    }
}
