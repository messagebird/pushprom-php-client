# Pushprom PHP client

This is a PHP client for [Pushprom](https://github.com/messagebird/pushprom). If you use Yii 2 you may want to have a look at the [Yii 2 client](https://github.com/messagebird/pushprom-yii-client).

[![Latest Stable Version](https://poser.pugx.org/messagebird/pushprom-php-client/v/stable.svg)](https://packagist.org/packages/messagebird/pushprom-php-client)
[![License](https://poser.pugx.org/messagebird/pushprom-php-client/license.svg)](https://packagist.org/packages/messagebird/pushprom-php-client)

## Installing

You can install the Pushprom PHP client through Composer by running:

```bash
composer require messagebird/pushprom-php-client:1.0.0
```

Alternatively, add this to your `composer.json`:

```json
"require": {
    "messagebird/pushprom-php-client": "1.0.0"
}
```

And then install by running:

```bash
composer update messagebird/pushprom-php-client
```

## Usage

```php
$con = new \pushprom\Connection('udp://127.0.0.1:9090');
$gauge = new \pushprom\Gauge($con,
    "fish_in_the_sea",
    "we eat fish and new fish is born",
    ["species" => "Thalassoma noronhanum"]);
$gauge->set(2000);
```

## License

The PHP client for Pushprom is licensed under [The BSD 2-Clause License](http://opensource.org/licenses/BSD-2-Clause). Copyright (c) 2016, MessageBird
