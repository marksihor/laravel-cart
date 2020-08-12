<?php

namespace MarksIhor\LaravelCart;

use Illuminate\Database\Eloquent\Collection;
use MarksIhor\LaravelCart\Exceptions\InvalidItemDataException;
use MarksIhor\LaravelCart\Models\{Cart as CartModel, CartItem};

class Cart
{
    protected CartModel $cart;

    public function __construct()
    {
        $this->cart = $this->getCart();
    }

    public function getContent(): Collection
    {
        return $this->cart->items;
    }

    public function getContentArray(): array
    {
        return $this->getContent()->toArray();
    }

    public function addItem(array $data): void
    {
        foreach (CartItem::REQUIRED_FIELDS as $field) {
            if (!key_exists($field, $data)) throw new InvalidItemDataException;
        }

        CartItem::create($this->formatItemData($this->cart, $data));
    }

    public function deleteItem(int $itemId): void
    {
        CartItem::where([
            'cart_id' => $this->cart->id,
            'id' => $itemId
        ])->delete();
    }

    public function clearCart()
    {
        CartItem::where('cart_id', $this->cart->id)->delete();
    }

    private function getCart(): CartModel
    {
        if (auth()->check()) {
            return CartModel::firstOrCreate(['user_id' => auth()->id()]);
        } else {
            return CartModel::firstOrCreate(['uuid' => Helpers::getUuid()]);
        }
    }

    private function formatItemData(CartModel $cart, array $data): array
    {
        // required fields
        $result = [
            'cart_id' => $cart->id,
            'product_id' => $data['product_id']
        ];

        // optional fields
        foreach (['price', 'discount', 'total', 'seller_id', 'data'] as $item) {
            if (key_exists($item, $data)) $result[$item] = $data[$item];
        }

        return $result;
    }
}