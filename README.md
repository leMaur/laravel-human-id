# Laravel Human IDs

[![Latest Version on Packagist](https://img.shields.io/packagist/v/lemaur/laravel-human-id.svg?style=flat-square)](https://packagist.org/packages/lemaur/laravel-human-id)
[![Total Downloads](https://img.shields.io/packagist/dt/lemaur/laravel-human-id.svg?style=flat-square)](https://packagist.org/packages/lemaur/laravel-human-id)
[![License](https://img.shields.io/packagist/l/lemaur/laravel-human-id.svg?style=flat-square&color=yellow)](https://github.com/leMaur/laravel-human-id/blob/main/LICENSE.md)
[![Tests](https://img.shields.io/github/actions/workflow/status/lemaur/laravel-human-id/run-tests.yml?label=tests&style=flat-square)](https://github.com/leMaur/laravel-human-id/actions/workflows/run-tests.yml)
[![GitHub Sponsors](https://img.shields.io/github/sponsors/lemaur?style=flat-square&color=ea4aaa)](https://github.com/sponsors/leMaur)
[![Trees](https://img.shields.io/badge/dynamic/json?color=yellowgreen&style=flat-square&label=Trees&query=%24.total&url=https%3A%2F%2Fpublic.offset.earth%2Fusers%2Flemaur%2Ftrees)](https://ecologi.com/lemaur?r=6012e849de97da001ddfd6c9)

This package has been inspired by the article "Designing APIs for humans: Object IDs" appeared on [Dev](https://dev.to/stripe/designing-apis-for-humans-object-ids-3o5a) (Aug 30, 2022 / by [Paul Asjes](https://dev.to/paulasjes)).

I really like the approach Stripe uses to define the object ID, so I figured out how to make something similar for Laravel.  
Basically, the package generate a so-called "human id" by prepending a prefix to a ULID with a separator between them.

An example should be better than a thousand words...

```md
👇 the structure -----------------

{prefix}{separator}{ulid}


👇 the params --------------------

prefix: post
separator: _
ulid: 26 alphanumeric characters


👇 the result --------------------

post_01h554vp2prg6zfayagh83ccx7
```

<br>

## Support Me

Hey folks,

Do you like this package? Do you find it useful, and it fits well in your project?

I am glad to help you, and I would be so grateful if you considered supporting my work.

You can even choose 😃:
* You can [sponsor me 😎](https://github.com/sponsors/leMaur) with a monthly subscription.
* You can [buy me a coffee ☕ or a pizza 🍕](https://github.com/sponsors/leMaur?frequency=one-time&sponsor=leMaur) just for this package.
* You can [plant trees 🌴](https://ecologi.com/lemaur?r=6012e849de97da001ddfd6c9). By using this link we will both receive 30 trees for free and the planet (and me) will thank you. 
* You can "Star ⭐" this repository (it's free 😉).

<br>

## Installation

You can install the package via composer:

```bash
composer require lemaur/laravel-human-id
```

<br>

## Usage

1. Add the "human ID" field in your migration files.    
2. Import the `Lemaur\HumanId\Concerns\HasHuids` trait into your eloquent model.

Here's a real-life example of how to implement the trait on a model.

```php
// database\migrations\create_posts_table.php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('posts', static function (Blueprint $table) {
            $table->id();
            
            $table->huid(); // <-- declare "huid" field
            
            // other fields...
        });
    }
}
```

```php
// app\Models\Post.php

namespace App\Models;

use \Illuminate\Database\Eloquent\Model;
use \Lemaur\HumanId\Concerns\HasHuids;

class Post extends Model
{
    use HasHuids; // <-- import trait
    
    /** @var string */
    private const HUID_PREFIX = 'post'; // <-- declare prefix (max 4 characters length)
}

// this will generate a huid like --> post_01h554vp2prg6zfayagh83ccx7
```

<br>

## Configuration

You can use a different name for the field (currently is "huid") and the separator character (currently is "_").  
To do that, you should publish the configuration file and change them from there.

```bash
php artisan vendor:publish --tag=human-id-config
```

<br>

## Testing

```bash
composer test
```

## Changelog

Please see [CHANGELOG](CHANGELOG.md) for more information on what has changed recently.

## Contributing

Please see [CONTRIBUTING](CONTRIBUTING.md) for details.

## Security Vulnerabilities

Please review [our security policy](../../security/policy) on how to report security vulnerabilities.

## Credits

- [leMaur](https://github.com/lemaur)
- [All Contributors](../../contributors)

## License

The MIT License (MIT). Please see [License File](LICENSE.md) for more information.
