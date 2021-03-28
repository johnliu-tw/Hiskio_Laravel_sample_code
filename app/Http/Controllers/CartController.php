<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Cart;
use App\Http\Services\CartService;

class CartController extends Controller
{
    protected $cartService;
    public function __construct(CartService $cartService)
    {
        $this->cartService = $cartService;
    }
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
            $result = $this->cartService->checkout($cart);
            return response(['result' => $result]);
        } else {
            return response('empty cart', 400);
        }
    }
}
