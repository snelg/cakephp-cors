# Cors plugin for CakePHP

A simple plugin to add CORS headers to specified requests.

In bootstrap.php, add something like

```
DispatcherFactory::add('Cors.Cors', ['routes' => [
    'ControllerClassName' => 'some_action',
    'OtherControllerClassName' => [
        'action_one' => ['origin' => 'somesite.com'],
        'action_two'],
    'ThirdController]]);
```

## Installation

You can install this plugin into your CakePHP application using [composer](http://getcomposer.org).

The recommended way to install composer packages is:

```
composer require your-name-here/Cors
```
