A simple way to return well formatted json responses in a Laravel application.

[![Latest Version on Packagist](https://img.shields.io/packagist/v/tequilarapido/result-cache.svg?style=flat-square)](https://packagist.org/packages/tequilarapido/result-cache)
[![Software License](https://img.shields.io/badge/license-MIT-brightgreen.svg?style=flat-square)](LICENSE.md)
[![Build Status](https://img.shields.io/travis/tequilarapido/result-cache/master.svg?style=flat-square)](https://travis-ci.org/tequilarapido/result-cache)
[![StyleCI](https://styleci.io/repos/70261592/shield)](https://styleci.io/repos/70685298)
[![SensioLabsInsight](https://img.shields.io/sensiolabs/i/89fef937-0983-4cea-8858-0a3d74875d9c.svg?style=flat-square)](https://insight.sensiolabs.com/projects/89fef937-0983-4cea-8858-0a3d74875d9c)
[![Quality Score](https://img.shields.io/scrutinizer/g/tequilarapido/result-cache.svg?style=flat-square)](https://scrutinizer-ci.com/g/tequilarapido/result-cache)
[![Code Coverage](https://img.shields.io/scrutinizer/coverage/g/tequilarapido/result-cache/master.svg?style=flat-square)](https://scrutinizer-ci.com/g/tequilarapido/result-cache/?branch=master)

<p align="center">
    <img src="https://s18.postimg.org/olwhc85a1/illustration.jpg" alt="Laravel Translation Sheet">
</p>


## Contents

- [Installation](#installation)
- [Usage](#usage)
- [Changelog](#changelog)
- [Testing](#testing)
- [Security](#security)
- [Contributing](#contributing)
- [Credits](#credits)
- [License](#license)


## Installation

You can install the package using composer

``` bash
$ composer require tequilarapido/result-cache
```

## Usage

### Cache 

* Create a class that extends ResultCache 

``` php      
use Tequilarapido\ResultCache\ResultCache;

class BooksCache extends ResultCache {

    public function key() {
        return 'app.books.all';
    }
    
    public function data() {
        // Some heavy / resources consuming operations
        // ...
        return $books;
    }
}
```

* Now you can simply call the get method to fetch cache. If the cache is invalid or not yet created, the operations will be executed.

``` php
class SomeController {
    public function books() {
          return (new BooksCache)->get();
    }
}
```

* Clean the cache

The package uses the default cache driver defined in your laravel application.

You can clean the cache using the `artisan cache:clear` 

You can also clean the cache programmatically using : 

``` php
  (new BooksCache)->forget()
```

### Application locale aware cache

Sometimes we need to cache something, but we need multiple versions depending on the application locale.
For this kind of use case we need to extend the `LocaleAwareResultCache`, and define the locales that are available in our application.

* Create a class that extends LocaleAwareResultCache 

``` php      
use Tequilarapido\ResultCache\LocaleAwareResultCache;

class BooksCache extends LocaleAwareResultCache {

    public function key() {
        return 'app.books.all';
    }
    
    public function data() {
        // Some heavy / resources consuming operations
        // We have access to $this->locale here to customize results according to locale
        // ...
        return $books;
    }
    
    public function  supportedLocales() {
        return ['en', 'fr', 'ar']
    }
}
```

* Now you can simply call the get method to fetch cache. If the cache is invalid or not yet created, the operations will be executed.

``` php
class SomeController {
    public function books() {
         return (new BooksCache)->setLocale($locale)->get();
    }
}
```

* Clean the cache

The package uses the default cache driver defined in your laravel application.

You can clean the cache using the `artisan cache:clear` 

You can also clean the cache programmatically using : 

``` php
  (new BooksCache)->forget()
```

this will clean cache for all locales.

### Cache expiration

By default, cache is created for one day. You can override the protected `$minutes` property on 
your cache class to specify how much minutes you want your cache before it gets invalidated.

``` php
use Tequilarapido\ResultCache\ResultCache;

class BooksCache extends ResultCache {

    protected $minutes = 60; // One hour
    
    // ...
}
```

## Changelog
Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## Testing

``` bash
$ composer test
```

## Security

If you discover any security related issues, please email :author_email instead of using the issue tracker.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Credits

- [Nassif Bourguig](https://github.com/nbourguig)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.






