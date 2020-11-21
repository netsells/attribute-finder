<?php

namespace Netsells\AttributeFinder\Tests\Unit;

use Netsells\AttributeFinder\AttributeFinder;
use Netsells\AttributeFinder\Tests\TestsFiles\TestAttributeOne;
use PHPUnit\Framework\TestCase;

class AttributeFinderTest extends TestCase
{
    private AttributeFinder $finder;

    public function setup(): void
    {
        parent::setup();
        $this->finder = new AttributeFinder(__DIR__ . '/../TestFiles');
    }

    public function testConvertsPathToClassCorrectly()
    {
        $classes = $this->finder->getClassesWithAttribute(TestAttributeOne::class);

        $this->assertIsArray($classes);
    }
}
