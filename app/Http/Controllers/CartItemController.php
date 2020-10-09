<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class CartItemController extends Controller
{
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
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $form = $request->all();
        DB::table('cart_items')->where('id', $id)
                               ->update(['quantity' => $form['quantity'],'updated_at' => now()]);
        return response()->json(true);
    }
}
