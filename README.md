# Shortlink Generator

## Introduction

Teertz Shortlink provides a simple way to generate a path of shortlink by passing an ID of your object and keep it in your database as you want.

The generated link is like: `http://example.com/abdg`;

### Basic Usage

To get started with Teertz Shortlink, add to your `composer.json` file as a dependency:

    composer require teertz/shorltink

#### Get the full path
```php
<?php

use Teertz\Shortlink\Generator as Shortlink;

class SomeClass
{
    public function saveObject($id)
    {
        /* some work before */

        $shortlink = (new Shortlink('http://example.com'))->get(1);
        // output 'http://example.com/aaaa';

        $shortlink = (new Shortlink('http://example.com'))->get(4);
        //output 'http://example.com/aaad';

        /* some work after */
    

    }
}
```

### Configuration with Laravel

Add the `Shortlink` facade to the `aliases` array in your `app` configuration file:

```php
'Shortlink' => Teertz\Shortlink\Generator::class,
```

## License

Teertz Shortlink is open-sourced software licensed under the [MIT license](http://opensource.org/licenses/MIT)