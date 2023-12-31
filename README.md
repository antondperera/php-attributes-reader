# PHP Attributes Reader

Welcome to PHP Attributes Reader, a lightweight and efficient library designed for effortlessly extracting and working with class, method, and property attributes in PHP 8. With the introduction of attributes in PHP 8, this library simplifies the process of reading and leveraging these attributes in your codebase. Whether you're exploring class, method, or property attributes, PHP Attributes Reader provides a user-friendly interface for seamless attribute retrieval, eliminating the need to deal with PHP's Reflection API directly. Enhance your development experience by easily tapping into the power of PHP 8 attributes with this intuitive and versatile library.

## Requirements

PHP 8.1 and later.

## Installation

You can install via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require antondperera/php-attributes-reader
```

Ensure you are using Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```

## Getting Started

Sample codes with simplest usages:

PHP Class with Class, Method and Property Attributes
```php
<?php

declare(strict_types=1);

#[TestAttribute1('testValue1')]
class Abc
{
    #[TestAttribute2('testValue2')]
    public ?string $test_property_1 = null;

    public ?string $test_property_2 = null;

    #[TestAttribute3('testValue3')]
    public function testMethod1()
    {
        // rest of the codes
    }

    public function testMethod2()
    {
        // rest of the codes
    }

    // rest of the codes
}
```

Simplest way on reading those Attributes
```php
<?php

declare(strict_types=1);

$class = Abc::class;

$attributes_reader = new \AntonDPerera\PHPAttributesReader\AttributesReader($class);

// Class attributes
echo $attributes_reader->hasClassAttributes(); // returns true
var_dump($attributes_reader->getClassAttributes()); // returns list of Class attributes


// Method attributes
echo $attributes_reader->hasMethodAttributes(); // returns true
echo $attributes_reader->hasMethodAttributes('testMethod2'); // returns false
echo $attributes_reader->hasMethodAttributes('testMethod1'); // returns true
var_dump($attributes_reader->getMethodAttributes('testMethod1')); // returns list of attributes for the given method. 


// Property attributes
echo $attributes_reader->hasPropertyAttributes(); // returns true
echo $attributes_reader->hasPropertyAttributes('test_property_2'); // returns false
echo $attributes_reader->hasPropertyAttributes('test_property_1'); // returns true
var_dump($attributes_reader->getPropertyAttributes('test_property_1')); // returns list of attributes for the given property.

```

For further details check the Documentation.


## Documentation

Check the [PHP Attributes Reader docs](https://anton-d-perera-open-source-libs.gitbook.io/php-attributes-reader/) for a complete guide with all the methods and examples, and learn how to use them.



## Limitations

PHP Attributes have many use cases. With the current version, PHP Attributes Reader covers much simpler usages of them. Check the [Limitations](hhttps://anton-d-perera-open-source-libs.gitbook.io/php-attributes-reader/limitations) section of PHP Attributes Reader docs for a more detailed guide. 



## Contribute

Please refer to the [Contribution Guide](https://anton-d-perera-open-source-libs.gitbook.io/php-attributes-reader/contribution) for information on how to contribute to PHP Attributes Reader.

