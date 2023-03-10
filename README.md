# All in one Laravel API Factory

[![Latest Stable Version](http://poser.pugx.org/dminustin/laravel-api-factory/v)](https://packagist.org/packages/dminustin/laravel-api-factory) [![Total Downloads](http://poser.pugx.org/dminustin/laravel-api-factory/downloads)](https://packagist.org/packages/dminustin/laravel-api-factory) [![Latest Unstable Version](http://poser.pugx.org/dminustin/laravel-api-factory/v/unstable)](https://packagist.org/packages/dminustin/laravel-api-factory) [![License](http://poser.pugx.org/dminustin/laravel-api-factory/license)](https://packagist.org/packages/dminustin/laravel-api-factory) [![PHP Version Require](http://poser.pugx.org/dminustin/laravel-api-factory/require/php)](https://packagist.org/packages/dminustin/laravel-api-factory)

All-in-one flexible and customizable code generator for Laravel framework that will save you time. This tool will help you generate resources like controllers, routes, swagger doc, postman collection.

It makes:
- Controllers
- Actions
- Routes
- Swagger Documentation
- Postman collection
- Unit tests for Actions

All my Laravel`s projects I have one pain: there is necessary to create routes, controllers, validators and such more routines. From project to project I have to do same actions.  
For this purpose, I wrote a composer component that helps me to make easily all of my tasks. I hope that my component will be helpful for other Laravel programmers.    
I will be glad to any feedback, comments, suggestions

### The general philosophy is:

"Actions" are contains all functionality, you may want to use it without HTTP requests, for example, in workers

"Controllers" must call "Actions" for any actions and must return an action result. No logic in controllers 

Default Directory/files structure:
```
config
 | api-factory.php
app
| routes
    | example.yaml
| http
  | ApiFactory
    | Actions
      | ...
    | Controllers
      | ...
```

Paths and filenames can changed in the api-factory.php file  
Routes directives you can see in [ROUTES](ROUTES.md).  
Controllers are extends the ApiFactoryController  
Actions are extends the ApiFactoryAction  
You can change parent classes in stubs  

Do not forget to add an exception in your app/Http/Middleware/VerifyCsrfToken.php file
```php
    //just example
    protected $except = [
        '/api/*'
    ];
```

## Todo
- implement middlewares in routes

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

## Step-by-step route creation
```php
php artisan api:create
```

### Testing

```bash
composer test
```

### Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information what has changed recently.

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.