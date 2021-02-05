ConfigDot
====

Get config from an array using a dot notation.

## Usage:

#### Create the config:

```php
<?php
$config = [
    'app' => [
        'name' => 'Foo Bar',
        'version' => 1
    ]
];
ConfigDot::setConfig($config);
```

#### Get a value:

```php
<?php
// set the config as above

$appName = ConfigDot::get('app.name');
// $appName = string(7) "Foo Bar" (or null if it does not exist)
```

#### Check if a value exists:

```php
<?php
// set the config as above

if (ConfigDot::has('app.name')) {
    // it does!
}
```

#### Set a new config value:

Setting a new config value doesn't eliminate the original value, but the order of priority will dictate that the new
value will be returned from a `get` request.

```php
<?php
// set the config as above

ConfigDot::update('app.name', 'Wolf');
```