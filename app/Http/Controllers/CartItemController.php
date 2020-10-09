<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateCartItem;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        try {
            $validatedData = $request->validate([
            'cart_id' => 'required|integer',
            'product_id' => 'required|integer',
            'quantity' => 'required|integer|between:1,10',
        ]);
        } catch (\Exception $exception) {
            if (get_class($exception) == 'Illuminate\Validation\ValidationException') {
                return response('false', 400);
            };
        }
        DB::table('cart_items')->insert(
            ['cart_id' => $validatedData['cart_id'],
             'product_id' => $validatedData['product_id'],
             'quantity' => $validatedData['quantity'],
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
    public function update(UpdateCartItem $request, $id)
    {
        $validatedData = $request->validated();

        DB::table('cart_items')->where('id', $id)
                               ->update(['quantity' => $validatedData['quantity'],'updated_at' => now()]);
        return response()->json(true);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        DB::table('cart_items')->where('id', $id)
                               ->delete();
        return response()->json(true);
    }
}
