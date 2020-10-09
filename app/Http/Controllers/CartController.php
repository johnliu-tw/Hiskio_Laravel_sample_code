<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $cart = DB::table('carts')->get()->first();
        if (empty($cart)) {
            DB::table('carts')->insert(['created_at' => now(), 'updated_at' => now()]);
            $cart = DB::table('carts')->get()->first();
        }
        $carItems = DB::table('cart_items')->where('cart_id', $cart->id)
                               ->get();
        $cart = collect($cart);
        $cart['items'] = collect($carItems);
        
        return response($cart);
    }
}
