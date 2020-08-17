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

### Usage examples

```php

\Cart::addItem([
            'product_id' => $product->id,
            'seller_id' => $product->user_id,
            'attributes' => $attributes,
            'price' => $product->price
        ]);
\Cart::getCart();
\Cart::getCart($cartId);
\Cart::getContentArray();
\Cart::getContentArray($cartId);
\Cart::getContent();
\Cart::getContent($cartId);
\Cart::deleteItem($itemId);
\Cart::clearCart();
\Cart::clearCart($itemId);
\Cart::getTotal($type); // price|total|discount|quantity
\Сart::getTotal($type, $cartId);
\Cart::updateItem($item, $data);

```

## License

MIT