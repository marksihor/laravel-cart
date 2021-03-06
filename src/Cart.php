<?php

namespace MarksIhor\LaravelCart;

use Illuminate\Database\Eloquent\Collection;
use MarksIhor\LaravelCart\Exceptions\InvalidItemDataException;
use MarksIhor\LaravelCart\Models\{Cart as CartModel, CartItem};

class Cart
{
    public function getContent(?int $cartId = null): ?Collection
    {
        $cart = $this->getCart($cartId);

        if (!$cart) return null;

        return $cart->items->load('product')->groupBy('seller_id');
    }

    public function getContentArray(?int $cartId = null): ?array
    {
        $content = $this->getContent($cartId);

        if (!$content) return null;

        return $content->toArray();
    }

    public function addItem(array $data): void
    {
        foreach (CartItem::REQUIRED_FIELDS as $field) {
            if (!key_exists($field, $data)) throw new InvalidItemDataException;
        }

        CartItem::create($this->formatItemData($this->getCart(), $data, 'create'));
    }

    public function updateItem(CartItem $item, array $data): void
    {
        $item->update($this->formatItemData($this->getCart(), $data));
    }

    public function updateItemById(int $itemId, array $data): void
    {
        $item = CartItem::where(['id' => $itemId, 'cart_id' => $this->getCart()->id])->first();

        if ($item) $this->updateItem($item, $data);
    }

    public function deleteItem(int $itemId): void
    {
        CartItem::where([
            'cart_id' => $this->getCart()->id,
            'id' => $itemId
        ])->delete();
    }

    public function getTotal(string $type, ?int $cartId = null): ?float
    {
        $cart = $this->getCart($cartId);

        if ($cart) {
            if (in_array($type, ['total', 'discount', 'price'])) {
                return CartItem::where('cart_id', $cart->id)->sum($type);
            } elseif ($type === 'quantity') {
                return CartItem::where('cart_id', $cart->id)->count();
            }
        }

        return null;
    }

    public function clearCart(?int $cartId = null)
    {
        $cart = $this->getCart($cartId);

        if ($cart) {
            CartItem::where('cart_id', $cart->id)->delete();
        }
    }

    public function getCart(?int $cartId = null): ?CartModel
    {
        if ($cartId) {
            return CartModel::find($cartId);
        } elseif (auth()->check()) {
            return CartModel::firstOrCreate(['user_id' => auth()->id()]);
        } else {
            return CartModel::firstOrCreate(['uuid' => Helpers::getUuid()]);
        }
    }

    private function formatItemData(CartModel $cart, array $data, string $type = null): array
    {
        // required fields

        if ($type === 'create') {
            $result = [
                'cart_id' => $cart->id,
                'product_id' => $data['product_id'],
                'seller_id' => $data['seller_id'],
            ];
        } else {
            $result = [];
        }

        // optional fields
        foreach (['price', 'discount', 'total', 'data', 'attributes'] as $item) {
            if (key_exists($item, $data)) $result[$item] = $data[$item];
        }

        return $result;
    }
}