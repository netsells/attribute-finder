# Attribute Finder
Attribute finder privides an easy way of getting a list of classes that have a specific attribute within a specified directory. Attribute finder will return a `Generator` of `ReflectionClass` instances for each class found that contains the given attribute.

## Installation

using composer:

```
composer require netsells/attribute-finder
```

## Usage
The `AttributeFinder` class needs to be initialised with the path to the directory you wish to scan. You can then call the
`getClassesWithAttribute()` which takes a single argument of the attribute name you're trying to seach for. `getClassesWithAttribute()` will then return an `Generator` instance containing a `ReflectionClass` instance for each class that has the given attribute in the specified directory.

```php
use Netsells\AttributeFinder\AttributeFinder;

$finder = new AttributeFinder(__DIR__);

$classes = $finder->getClassesWithAttribute(TestAttribute::class);
```

Once you have the `Generator` instance you are free to iterate over it and retrieve the attributes
```php
foreach ($classes as $class) {
    $attribute = $class->getAttributes(TestAttribute::class)[0];
    $attributeInstance = $attribute->newInstance();
    // Do whatever you want with the given attribute instance
}
```