<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateCartItem;
use App\Models\Cart;
use App\Models\CartItem;

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
        $cart = Cart::find($validatedData['cart_id']);
        $result = $cart->cartItems()->create(
            ['product_id' => $validatedData['product_id'],
             'quantity' => $validatedData['quantity']]
        );

        return response()->json($result);
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
        $item = CartItem::find($id);
        $item->fill(['quantity' => $validatedData['quantity']]);
        // do something
        $item->save();
                               
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
        $item = CartItem::find($id)->delete();
        return response()->json(true);
    }
}
