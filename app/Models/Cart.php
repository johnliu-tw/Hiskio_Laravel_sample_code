<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'checkouted'];
    protected $rate = 1;
    public function cartItems()
    {
        return $this->hasMany(CartItem::class);
    }
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    public function order()
    {
        return $this->hasOne(Order::class);
    }
    public function checkout()
    {
        foreach ($this->cartItems as $cartItem) {
            $product = $cartItem->product;
            if ($product->quantity < $cartItem->quantity) {
                return $product->title.' 數量不足';
            }
        }

        $order = $this->order()->create([
            'user_id' => $this->user_id,
            'is_shipped' => false
        ]);
        
        if ($this->user->level == 2) {
            $this->rate = 0.8;
        }

        foreach ($this->cartItems as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'price' => $cartItem->product->price*$this->rate
            ]);

            $product->update(['quantity' => $product->quantity - $cartItem->quantity]);
        }
        $this->update(['checkouted' => true]);
        $order->orderItems;
        return $order;
    }
}
