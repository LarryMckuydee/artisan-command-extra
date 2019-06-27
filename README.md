# Artisan Extra Command
=======================

Artisan extra command aims to provide more command and automation to laravel php artisan to help speed up development speed for all laravel developers.

# How it works ?
================
Basically, it just extends from laravel Command class

# Installation
==============

Install via composer
`composer require larrymckuydee/artisan-command-extra`

Include into `app/Console/Kernel.php

** Database Migrations **

```php
use ArtisanCommandExtra\Console\Migrations as Migrations;

...

class Kernel extends ConsoleKernel
{
...
    protected $command = [
        Migrations\CreateCommand::class,
	Migrations\DropCommand::class
    ];

}

```

## Authors
* LarryMckuydee
