# CORS plugin for CakePHP 3.x

[![Build Status](https://travis-ci.org/LeWestopher/cakephp-cors.svg?branch=master)](https://travis-ci.org/LeWestopher/cakephp-cors)
[![Coverage](https://img.shields.io/coveralls/LeWestopher/cakephp-cors/master.svg)](https://travis-ci.org/snelg/cakephp-cors)
[![Downloads](https://img.shields.io/packagist/dt/snelg/cakephp-cors.svg?style=flat-square)](https://packagist.org/packages/snelg/cakephp-cors)



A simple plugin to add CORS headers to specified requests.

## Requirements

 * CakePHP 3.0+
 * PHP 5.4+

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

To install this plugin, in your terminal type:

```
composer require snelg/cakephp-cors:dev-master
```

### Unlocking CORS for a single controller

Define a single key within the routes array in the DispatcherFactory options array:

```php
DispatcherFactory::add('Cors.Cors', ['routes' => [
    'ControllerClassName'
]]);
```

### Unlocking CORS for a controller scoped to a single action

Define a nested array consisting of 'controller' => 'action' within the routes array in DispatcherFactor options:

```php
DispatcherFactory::add('Cors.Cors', ['routes' => [
    'ControllerClassName' => 'some_action',
]]);
```

### Scoping CORS to particular origins

```php
DispatcherFactory::add('Cors.Cors', ['routes' => [
    'ControllerClassName' => [
        'action_one' => ['origin' => 'somesite.com']
]]);
```

### Scoping CORS to particular methods

```php
DispatcherFactory::add('Cors.Cors', ['routes' => [
   'ControllerClassName' => [
       'action_one' => [
           'origin' => 'somesite.com',
           'methods' => ['PUT', 'DELETE']
       ]
]]);
```

### Setting CORS within Router::connect

```php
Router::scope('/', function ($routes) {
    $routes->connect('/public_api',
    ['controller' => 'ControllerClass', 'action' => 'action_one', 'cors' => true]]
});
}
```

### Router::connect with custom origins, methods, and headers

```php
Router::scope('/', function ($routes) {
    $routes->connect('/public_api', [
        'controller' => 'ControllerClass',
        'action' => 'action_one',
        'cors' => [
            'origin' => 'your_origin.com',
            'methods' => ['PUT', 'DELETE'],
            'headers' => []
        ]
    ]);
});
}
```

### Support

For bugs and feature requests, please use the [issues](https://github.com/snelg/cakephp-cors/issues) section of this repository.

### Contributing

To contribute to this plugin please follow a few basic rules.

* Contributions must follow the [CakePHP coding standard](http://book.cakephp.org/3.0/en/contributing/cakephp-coding-conventions.html).
* [Unit tests](http://book.cakephp.org/3.0/en/development/testing.html) are required.

### Creators

[Glen Sawyer](http://www.github.com/snelg) && [Wes King](http://www.github.com/lewestopher)

### License

Copyright 2015, Glen Sawyer and Wes King

Licensed under The MIT License Redistributions of files must retain the above copyright notice.
