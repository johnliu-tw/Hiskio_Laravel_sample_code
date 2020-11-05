<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Product;
use Illuminate\Support\Facades\Redis;

class ProductController extends Controller
{
    public function index()
    {
        // $products = DB::table('products')->get();
        $products = json_decode(Redis::get('products'));
        return response($products);
    }

    public function checkProduct(Request $request)
    {
        $id = $request->all()['id'];
        $product = Product::find($id);
        if ($product->quantity > 0) {
            return response(true);
        } else {
            return response(false);
        }
    }
}
