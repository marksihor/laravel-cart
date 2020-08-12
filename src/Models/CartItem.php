<?php

namespace MarksIhor\LaravelCart\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    const REQUIRED_FIELDS = ['attributes', 'product_id'];

    protected $guarded = ['id'];

    protected $hidden = ['updated_at', 'chat_id'];

    protected $casts = [
        'attributes' => 'array',
        'data' => 'array'
    ];

    public function cart()
    {
        return $this->belongsTo('MarksIhor\LaravelCart\Models\Cart');
    }

    public function product()
    {
        return $this->belongsTo(config('cart.product'));
    }

    public function seller()
    {
        return $this->belongsTo(config('cart.seller'));
    }
}
