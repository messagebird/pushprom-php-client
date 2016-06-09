# Pushprom php client

This is a php client for [Pushprom](https://github.com/messagebird/pushprom).
If you use yii2 you may want to give a look at [the yii client](https://github.com/messagebird/pushprom-yii-client) repo.




# Installing

Add this to your composer.json:

```json
    "repositories": [
        {
            "type": "vcs",
            "url": "https://github.com/messagebird/pushprom-php-client"
        }
    ],
    "require": {
        "messagebird/pushprom-php-client": "dev-master"
    }

```

and then install

```bash
composer update messagebird/pushprom-php-client
```

# Using it

```php
$con = new \pushprom\Connection('udp://127.0.0.1:9090');
$gauge = new \pushprom\Gauge($con,
    "fish_in_the_sea",
    "we eat fish and new fish is born",
    ["species" => "Thalassoma noronhanum"]);
$gauge->set(2000);
```

# Tests

```
phpunit .
```
