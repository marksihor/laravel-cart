<?php

namespace MarksIhor\LaravelCart\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $guarded = [];

    public function items()
    {
        return $this->hasMany('MarksIhor\LaravelCart\Models\CartItem')
            ->orderBy('id', 'desc');
    }

    public function user()
    {
        return $this->belongsTo(config('auth.providers.users.model'));
    }
}