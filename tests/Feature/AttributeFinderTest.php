<?php

namespace Netsells\AttributeFinder\Tests\Feature;

use PHPUnit\Framework\TestCase;
use Netsells\AttributeFinder\AttributeFinder;
use Netsells\AttributeFinder\Tests\TestsFiles\TestAttributeOne;
use Netsells\AttributeFinder\Tests\TestsFiles\TestAttributeTwo;
use Netsells\AttributeFinder\Tests\TestsFiles\TestAttributeOneClass;
use Netsells\AttributeFinder\Tests\TestsFiles\TestClasses\TestAttributeTwoClass;
use Netsells\AttributeFinder\Tests\TestsFiles\TestClasses\TestAttributeOneClassTwo;

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
        $actual = $this->finder->getClassesWithAttribute(TestAttributeOne::class);

        $expected = [
            TestAttributeOneClassTwo::class,
            TestAttributeOneClass::class,
        ];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testGetsAlternativeAttributeClasses()
    {
        $actual = $this->finder->getClassesWithAttribute(TestAttributeTwo::class);

        $expected = [
            TestAttributeTwoClass::class,
        ];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testReturnsEmptyArrayForInvalidAttribute()
    {
        $actual = $this->finder->getClassesWithAttribute('InvalidAttribute');

        $expected = [];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }

    public function testGetsAllBaseAttributes()
    {
        $actual = $this->finder->getClassesWithAttribute(\Attribute::class);

        $expected = [
            TestAttributeOne::class,
            TestAttributeTwo::class,
        ];

        $this->assertIsArray($actual);
        $this->assertEquals($expected, $actual);
    }
}
