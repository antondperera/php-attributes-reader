# PHP Attributes Reader

Welcome to PHP Attributes Reader, a lightweight and efficient library designed for effortlessly extracting and working with class, method, and property attributes in PHP 8. With the advent of attributes in PHP 8, this library simplifies the process of reading and leveraging these attributes in your codebase. Whether you're exploring class, method or property attributes, PHP Attributes Reader provides a user-friendly interface for seamless attribute retrieval so you don't have to deal with PHP's Reflection API directly. Enhance your development experience by easily tapping into the power of PHP 8 attributes with this intuitive and versatile library.

## Requirements

PHP 8.1 and later.

## Installation

You can install via [Composer](http://getcomposer.org/). Run the following command:

```bash
composer require antondperera/php-attributes-reader
```

Make sure you are using Composer's [autoload](https://getcomposer.org/doc/01-basic-usage.md#autoloading):

```php
require_once 'vendor/autoload.php';
```

## Getting Started

Simple usage looks like:

Class with Attributes
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
var_dump($attributes_reader->getMethodAttributes('testMethod1')); // returns list of Method attributes 


// Method attributes
echo $attributes_reader->hasPropertyAttributes(); // returns true
echo $attributes_reader->hasPropertyAttributes('test_property_2'); // returns false
echo $attributes_reader->hasPropertyAttributes('test_property_1'); // returns true
var_dump($attributes_reader->getPropertyAttributes('test_property_1')); // returns list of Method attributes 

```

For further details check the Documentation.


## Documentation

Check the [PHP Attributes Reader docs](https://php-attributes-reader.gitbook.io) for completed guide with all the methods and examples that you can use and how to use them.



## Limitations

PHP Attributes has many use cases. With the current version of PHP Attributes Reader covers much simpler usages of it. Check the [Limitations](https://php-attributes-reader.gitbook.io/introduction/limitations) section of PHP Attributes Reader docs for more detailed guide. 



## Contribute

Please refer to [Contribution Guide](https://php-attributes-reader.gitbook.io/introduction/contribute) for information on how to contribute to PHP Attributes Reader.

