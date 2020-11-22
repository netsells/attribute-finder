<?php

namespace Netsells\AttributeFinder\Tests\Feature;

use Generator;
use ReflectionClass;
use PHPUnit\Framework\TestCase;
use Netsells\AttributeFinder\AttributeFinder;
use Netsells\AttributeFinder\Exceptions\InvalidDirectoryException;
use Netsells\AttributeFinder\Tests\TestFiles\TestAttributeOne;
use Netsells\AttributeFinder\Tests\TestFiles\TestAttributeTwo;
use Netsells\AttributeFinder\Tests\TestFiles\TestAttributeOneClass;
use Netsells\AttributeFinder\Tests\TestFiles\TestClasses\TestAttributeTwoClass;
use Netsells\AttributeFinder\Tests\TestFiles\TestClasses\TestAttributeOneClassTwo;

class AttributeFinderTest extends TestCase
{
    private AttributeFinder $finder;

    public function setup(): void
    {
        parent::setup();
        $this->finder = new AttributeFinder(__DIR__ . '/../TestFiles');
    }

    public function testGetsAttributesInDirectory()
    {
        $actualGenerator = $this->finder->getClassesWithAttribute(TestAttributeOne::class);

        $expectedClasses = [
            new ReflectionClass(TestAttributeOneClassTwo::class),
            new ReflectionClass(TestAttributeOneClass::class),
        ];

        $actualClasses = [];

        foreach ($actualGenerator as $class) {
            $actualClasses[] = $class;
        }

        $this->assertEquals(Generator::class, $actualGenerator::class);
        $this->assertCount(2, $actualClasses);
        $this->assertEquals($expectedClasses, $actualClasses);
    }

    public function testGetsAlternativeAttributeClasses()
    {
        $actualGenerator = $this->finder->getClassesWithAttribute(TestAttributeTwo::class);

        $expectedClasses = [
            new ReflectionClass(TestAttributeTwoClass::class),
        ];

        $actualClasses = [];

        foreach ($actualGenerator as $class) {
            $actualClasses[] = $class;
        }

        $this->assertEquals(Generator::class, $actualGenerator::class);
        $this->assertCount(1, $actualClasses);
        $this->assertEquals($expectedClasses, $actualClasses);
    }

    public function testReturnsEmptyArrayForInvalidAttribute()
    {
        $actualGenerator = $this->finder->getClassesWithAttribute('InvalidAttribute');

        $expectedClasses = [];

        $actualClasses = [];

        foreach ($actualGenerator as $class) {
            $actualClasses[] = $class;
        }

        $this->assertEquals(Generator::class, $actualGenerator::class);
        $this->assertCount(0, $actualClasses);
        $this->assertEquals($expectedClasses, $actualClasses);
    }

    public function testGetsAllBaseAttributes()
    {
        $actualGenerator = $this->finder->getClassesWithAttribute(\Attribute::class);

        $expectedClasses = [
            new ReflectionClass(TestAttributeOne::class),
            new ReflectionClass(TestAttributeTwo::class),
        ];

        $actualClasses = [];

        foreach ($actualGenerator as $class) {
            $actualClasses[] = $class;
        }

        $this->assertEquals(Generator::class, $actualGenerator::class);
        $this->assertCount(2, $actualClasses);
        $this->assertEquals($expectedClasses, $actualClasses);
    }

    public function testThrowsExceptionForInvalidDirectory()
    {
        $this->expectException(InvalidDirectoryException::class);
        new AttributeFinder('invalid directory');
    }
}
