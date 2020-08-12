# laravel-cart

## Installing

```shell
$ composer require marksihor/laravel-cart -vvv
```

## CONFIGURATION

1. Run the command in your terminal

```php
$ php artisan vendor:publish --provider="MarksIhor\\LaravelCart\\CartServiceProvider" --tag=config
```

2. Open config/app.php and add this line to your Aliases

```php
  'Cart' => MarksIhor\LaravelCart\Facades\CartFacade::class,
```

3. Open App\Http\Kernel.php and add this line to $routeMiddleware array

```php
  'cart' => \MarksIhor\LaravelCart\Http\Middleware\CartMiddleware::class,
```

4. Use "cart" middleware on routes you nedd to access cart

## License

MIT