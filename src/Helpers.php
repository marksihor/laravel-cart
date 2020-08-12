<?php

namespace MarksIhor\LaravelCart;

class Helpers
{
    public static function getUuid(): ?string
    {
        if (config('cart.storage') === 'session') {
            return session('cartUuid');
        } elseif (config('cart.storage') === 'cache') {
            // to do
        }

        return null;
    }

    public static function setUuid(string $identifier): void
    {
        if (config('cart.storage') === 'session') {
            session(['cartUuid' => $identifier]);
        } elseif (config('cart.storage') === 'cache') {
            // to do
        }
    }
}