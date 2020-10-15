<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    use HasFactory;

    protected $fillable = ['user_id', 'checkouted'];
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
        $order = $this->order()->create([
            'user_id' => $this->user_id,
            'is_shipped' => false
        ]);
        foreach ($this->cartItems as $cartItem) {
            $order->orderItems()->create([
                'product_id' => $cartItem->product_id,
                'price' => $cartItem->product->price
            ]);
        }
        $this->update(['checkouted' => true]);
        $order->orderItems;
        return $order;
    }
}
