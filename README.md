# Bright Nucleus Keys

[![Latest Stable Version](https://img.shields.io/packagist/v/brightnucleus/keys.svg)](https://packagist.org/packages/brightnucleus/keys)
[![Total Downloads](https://img.shields.io/packagist/dt/brightnucleus/keys.svg)](https://packagist.org/packages/brightnucleus/keys)
[![Latest Unstable Version](https://img.shields.io/packagist/vpre/brightnucleus/keys.svg)](https://packagist.org/packages/brightnucleus/keys)
[![License](https://img.shields.io/packagist/l/brightnucleus/keys.svg)](https://packagist.org/packages/brightnucleus/keys)

This package provides validatable key objects that are meant to be used as identifiers.

## Table Of Contents

* [Installation](#installation)
* [Basic Usage](#basic-usage)
* [Advanced Usage](#advanced-usage)
* [Contributing](#contributing)
* [License](#license)

## Installation

The best way to use this package is through Composer:

```BASH
composer require brightnucleus/keys
```

## Basic Usage

### Basic `Key` class

Usage of the basic `BrightNucleus\Keys\Key` class is very simple, you just instantiate it by passing the actual value you want to use as a key through the constructor.
 
Example:

```php
<?php namespace Vendor\Package;

use BrightNucleus\Keys\Key;

$key = new Key('my_option');
echo $key;
// Output: 'my_option'
```

### `UUID` class

An UUID is a ["Universally Unique IDentifier"](https://en.wikipedia.org/wiki/Universally_unique_identifier).

To use the `BrightNucleus\Keys\UUID` class, you should instantiate it through one of the named constructors:

* `UUID::uuid1()`: Generate a version 1 (time-based) UUID object.
* `UUID::uuid3($namespace, $name)`: Generate a version 3 (name-based and hashed with MD5) UUID object.
* `UUID::uuid4()`: Generate a version 4 (random) UUID object.
* `UUID::uuid5($namespace, $name)`: Generate a version 5 (name-based and hashed with SHA1) UUID object.
 
Example:

```php
<?php namespace Vendor\Package;

use BrightNucleus\Keys\UUID;

$randomUUID = UUID::uuid4();
echo $randomUUID;
// Output: random UUID, in a format similar to '123e4567-e89b-12d3-a456-426655440000'

$hashedUUID = UUID::uuid5(UUID::NAMESPACE_URL, 'https://www.brightnucleus.com');
echo $hashedUUID;
// Output: '63ab6383-0ad4-559a-b16b-afcec9cc77e9'
```

## Advanced Usage

You can extend the `BrightNucleus\Keys\Key` class to provide your own unique scheme for providing identifiers. Ensure that both the validation as well as the serialization features work as intended for your custom implementation.

Example:

```php
<?php namespace Vendor\Package;

use BrightNucleus\Keys\Key;

class TimestampedKey extends Key
{

    /**
     * Initialize a new TimestampedKey object.
     */
    public function __construct()
    {
        $dateTime = new \DateTimeImmutable();
        $this->data = $dateTime->getTimestamp();
    }
}

$key = new TimestampedKey();
echo $key;
// Output: Unix timestamp value in the format '1499248161';
```

## Contributing

All feedback / bug reports / pull requests are welcome.

## License

Copyright (c) 2017 Alain Schlesser, Bright Nucleus

This code is licensed under the [MIT License](LICENSE).
