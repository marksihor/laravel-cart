<?php

namespace MarksIhor\LaravelCart\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use MarksIhor\LaravelCart\Helpers;
use MarksIhor\LaravelCart\Models\Cart;

class CartMiddleware
{
    public function handle($request, Closure $next)
    {
        $cartUuid = Helpers::getUuid();

        if (auth()->guest() && !$cartUuid) {
            Helpers::setUuid((string)Str::uuid());
        }

        if (auth()->check() && $cartUuid) {
            Cart::where('uuid', $cartUuid)
                ->update(['user_id' => auth()->id()]);
        }

        return $next($request);
    }
}