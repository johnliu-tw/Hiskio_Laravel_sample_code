<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\UpdateCartItem;
use App\Models\Cart;
use App\Models\CartItem;
use App\Models\Product;
use Illuminate\Support\Facades\Validator;

class CartItemController extends Controller
{
    public function store(Request $request)
    {
        $messages = [
            'required' => ':attribute 是必要的',
            'between' => ':attribute 的輸入 :input 不在 :min 與 :max 之間',
        ];
        $validator = Validator::make($request->all(), [
                'cart_id' => 'required|integer',
                'product_id' => 'required|integer',
                'quantity' => 'required|integer|between:1,10',
        ], $messages);
        if ($validator->fails()) {
            return response($validator->errors(), 400);
        }
        $validatedData = $validator->validate();

        $product = Product::find($validatedData['product_id']);
        if (!$product->checkQuantity($validatedData['quantity'])) {
            return response($product->title.'數量不足', 400);
        }
        
        $cart = Cart::find($validatedData['cart_id']);
        $result = $cart->cartItems()->create(
            ['product_id' => $product->id,
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
    public function destroy(Request $request, $id)
    {
        $adminToken = $request->header('admin-token');
        if ($adminToken && $adminToken == env('ADMIN_TOKEN')) {
            CartItem::withTrashed()->find($id)->forceDelete();
        } else {
            CartItem::find($id)->delete();
        }
        return response()->json(true);
    }
}
