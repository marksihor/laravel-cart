<?php

return [
    // Your product model
    'product' => 'App\Models\Product',
    'seller' => 'App\Models\User',

    // The place where to store user identifier wether logged in or not, available options: session, cache
    'storage' => 'session'
];