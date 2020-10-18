<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Models\CartItem;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $user = auth()->user();
        $cart = Cart::with('cartItems')->where('user_id', $user->id)->firstOrCreate(['user_id' => $user->id]);
        
        return response($cart);
    }

    public function checkout()
    {
        $user = auth()->user();
        $cart = $user->carts()->where('checkouted', false)->with('cartItems')->first();
        if ($cart) {
            $result = $cart->checkout();
            return response(['result' => $result]);
        } else {
            return response('empty cart', 400);
        }
    }
}
