# Attribute Finder
Attribute finder privides an easy way of getting a list of classes that have a specific attribute within a specified directory.

## Installation

using composer:

```
composer require netsells/attribute-finder
```

## Usage
The `AttributeFinder` class needs to be initialised with the path to the directory you wish to scan. You can then call the
`getClassesWithAttribute()` which takes a single argument of the attribute name you're trying to seach for. `getClassesWithAttribute()` will then return an array containing the fully qualified names of each class that has the given attribute in the specified directory.

```php
use Netsells\AttributeFinder\AttributeFinder;

$finder = new AttributeFinder(__DIR__);

$finder->getClassesWithAttribute(\Attribute::class);
```