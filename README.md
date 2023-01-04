# All in one Laravel API Factory

[![Latest Version on Packagist](https://img.shields.io/packagist/v/dminustin/laravel-api-factory.svg?style=flat-square)](https://packagist.org/packages/dminustin/laravel-api-factory)

This package helps to fast generate APIs

It makes:
- Controllers
- Actions
- Routes
- Swagger Documentation

### The general philosophy is:

"Actions" contains all functionality, you may want to use it without HTTP requests, for example, in workers

"Controllers" must call "Actions" for any actions and must return an action result. No logic in controllers 

Default Directory structure:
```
app
| http
  | ApiFactory
    | Actions
    | Controllers
```

Controllers extends the ApiFactoryController

Actions extends the ApiFactoryAction

You can chane parent classes in stubs


## Todo
- implement middlewares in routes
- extend controller stub
- add postman collection writer

## Installation

You can install the package via composer:

```bash
composer require dminustin/laravel-api-factory
```

## Swagger documentation
```bash
composer require --dev DarkaOnLine/L5-Swagger
```

API Documentation will be available at /api/documentation 
```
http://127.0.0.1:8000/api/documentation
```

## Configure
```bash
php artisan vendor:publish --tag=api-factory
```

Change the configuration file config/api-factory.php

You can change ./stubs files
- api_factory_action
- api_factory_controller
- api_factory_router

## Usage

```php
php artisan api:factory
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.