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


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $form = $request->all();
        DB::table('cart_items')->insert(
            ['cart_id' => $form['cart_id'],
             'product_id' => $form['product_id'],
             'quantity' => $form['quantity'],
             'created_at' => now(),
             'updated_at' => now()]
        );
        return response()->json(true);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
