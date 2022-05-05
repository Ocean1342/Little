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
Add connection to database in app/config.php 
and phinx.php

Run migrations:
```
composer migrate
```
Up your server or use Built-in web server: 
```
composer serve
```