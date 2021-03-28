<?php
namespace App\Http\Services;

use Illuminate\Support\Facades\DB;

class CartService
{
    const VIP_LEVEL = 2;
    const VIP_RATE = 0.8;
    const NORMAL_RATE = 1.0;
    public function checkout($cart)
    {
        $result = DB::transaction(function () use ($cart) {
            $lackCartItem = $this->checkLackCartItem($cart->cartItems);
            if ($lackCartItem) {
                return $lackCartItem->product->title.'數量不足';
            }
            $rate = $this->cartRate($cart);
            $order = $this->createOrder($cart, $rate);
            $cart->update(['checkouted' => true]);
            $order->orderItems;
            return $order;
        });

        return $result;
    }

    public function checkLackCartItem($cartItems)
    {
        return $cartItems->filter(function ($cartItem) {
            return $cartItem->product->quantity < $cartItem->quantity;
        })->first();
    }

    public function cartRate($cart)
    {
        return $cart->user->level == self::VIP_LEVEL ? self::VIP_RATE : self::NORMAL_RATE;
    }

    public function createOrder($cart, $rate)
    {
        $order = $cart->order()->create([
            'user_id' => $cart->user_id,
            'is_shipped' => false
        ]);
        foreach ($cart->cartItems as $cartItem) {
            $product = $cartItem->product;
            $order->orderItems()->create([
                'product_id' => $product->id,
                'price' => $product->price * $rate
            ]);
            $product->update(['quantity' => $product->quantity - $cartItem->quantity]);
        }

        return $order;
    }
}
