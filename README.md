# Short links service

## Requirements

- Git
- PHP >= 8.0
- Composer

## Installation

Clone this repository:

```
git clone https://github.com/Ocean1342/Little.git
```

Install via composer:

```
composer install
```

Configure database connection in app/db.config.php:

```

$arDbConfig = [
    'production' => [
        'dbname' => 'your db name',
        'host' => 'host',
        'user' => 'user',
        'password' => 'password'
    ]
];
```

Run migrations:

```
composer migrate
```

Up your server or use Built-in web server:

```
composer serve
```