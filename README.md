# CORS plugin for CakePHP 3.x

A simple plugin to add CORS headers to specified requests.

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

To install this plugin, in your terminal type:

```
TODO: Set this up for proper Composer require functionality || composer require your-name-here/Cors
```

## Unlocking CORS for a single controller

Define a single key within the routes array in the DispatcherFactory options array:

```
DispatcherFactory::add('Cors.Cors', ['routes' => [
    'ControllerClassName'
]]);
```

## Unlocking CORS for a controller scoped to a single action

Define a nested array consisting of 'controller' => 'action' within the routes array in DispatcherFactor options:

```
DispatcherFactory::add('Cors.Cors', ['routes' => [
    'ControllerClassName' => 'some_action',
]]);
```

## Unlocking CORS for a controller/action scoped to particular origins

```
DispatcherFactory::add('Cors.Cors', ['routes' => [
    'ControllerClassName' => [
        'action_one' => ['origin' => 'somesite.com']
]]);
```

## Unlocking CORS for a controller/actions scoped to particular methods

```
DispatcherFactory::add('Cors.Cors', ['routes' => [
   'ControllerClassName' => [
       'action_one' => [
           'origin' => 'somesite.com',
           'methods' => ['PUT', 'DELETE']
       ]
]]);
```
