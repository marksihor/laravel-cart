<?php

namespace MarksIhor\LaravelCart;

use Illuminate\Database\Eloquent\Collection;
use MarksIhor\LaravelCart\Exceptions\InvalidItemDataException;
use MarksIhor\LaravelCart\Models\{Cart as CartModel, CartItem};

class Cart
{
    public function getContent(): Collection
    {
        return $this->getCart()->items->groupBy('seller_id');
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

    public function getTotal(string $type): float
    {
        if (in_array($type, ['total', 'discount', 'price'])) {
            return CartItem::where('cart_id', $this->getCart()->id)->sum($type);
        }

        return 0;
    }

    public function clearCart()
    {
        CartItem::where('cart_id', $this->getCart()->id)->delete();
    }

    private function getCart(): CartModel
    {
        if (auth()->check()) {
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