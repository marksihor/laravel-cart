<?php

namespace MarksIhor\LaravelCart\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $guarded = ['id'];

    protected $hidden = ['updated_at', 'chat_id'];

    protected $casts = [
        'data' => 'array'
    ];

    public function cart()
    {
        return $this->belongsTo('MarksIhor\LaravelCart\Models\Cart');
    }

    public function model()
    {
        return $this->belongsTo(config('cart.model'));
    }
}
