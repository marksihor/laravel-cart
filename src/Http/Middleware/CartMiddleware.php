<?php

namespace MarksIhor\LaravelCart\Http\Middleware;

use Closure;
use Illuminate\Support\Str;
use MarksIhor\LaravelCart\Models\Cart;

class CartMiddleware
{
    public function handle($request, Closure $next)
    {
        $cartSessionId = session('cartSessionId');

        if (auth()->guest() && !$cartSessionId) {
            session(['cartSessionId' => (string)Str::uuid()]);
        }

        if (auth()->check()) {
            if ($cartSessionId && $cartSessionId !== auth()->id()) {
                Cart::where('id', $cartSessionId)
                    ->update(['user_id' => auth()->id()]);
            }

            session(['cartSessionId' => auth()->id()]);
        }

        return $next($request);
    }
}
