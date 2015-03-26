# SimilarWeb API PHP Client

## Introduction

[SimilarWeb](http://www.similarweb.com) is a project created by [SimilarGroup](http://www.similargroup.com) company. It collects and provides access to various website analytics. This is a PHP library implementing easy access to their [API](https://developer.similarweb.com/).


## Requirements:

- PHP 5.3 (namespaces),
- [php-curl-class](https://github.com/php-curl-class/php-curl-class) library (Curl request lib).

## Installation:

This library is available on [Packagist](https://github.com/druidoff/SimilarWebApi) and uses `merlinoff/SimilarWebApi` alias. If you use [Composer](https://getcomposer.org/) (and if you don't I don't know what you're waiting for) you can `composer require` it:

```
composer require merlinoff/SimilarWebApi
```

Alternatively you can place it manually inside your `composer.json`:

```
(...)
"require": {
    "merlinoff/SimilarWebApi": "dev-master"
}
(...)
```

and then run `composer install` or `composer update` as required.


You can of course make it a [git submodule](http://git-scm.com/docs/git-submodule), download and place it in your project next to your regular code or something, but really, do yourself (and the whole industry) a favor and use Composer.

## Usage:

All APIs implemented in this library have the Request and Response classes named corresponding to those defined in SimilarWeb API documentation. Expected data should be retrieved by first visiting SimilarWeb API documentation and then using Request class with the same name located in `src/Request` directory. Method `getResponse()` demonstrated below will automatically match, create and return matching Response class object which can be type hinted and relied on. There is also ClientFacade class which contains easy to use interface (note that this class is auto-generated):

```php
use merlinoff\SimilarWeb;

// create client object
$sw = new SimilarWeb($token);
$sw->setDomain("google.com");

// fetch response by passing API call name and desired domain
$result = $sw->getRankAndReach();


// or get category rank
$result = $sw->getCategoryRank();


// or get Traffic
$result = $sw->getTraffic("9-2014", "2-2015");

etc...
```


APIs return objects with keys containing four types of data:

During either `composer install`, `composer update` or manual execution of `php bin/generate` command, API mapping configuration is used to generate domain request and response classes with methods hiding library complexity behind readable accessors. Such approach makes it possible to have readable class API, good IDE autocompletion and highlighting possibilities with no additional programming work. When response is parsed all elements of given type are put inside their containers and those response classes act as a facade for raw response object.


## License
GNU General Public License
