<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\Product;
use App\Http\Services\ShortUrlService;

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

    public function sharedUrl($id)
    {
        $service = new ShortUrlService();
        $url = $service->makeSortUrl("http://localhost:3000/products/$id");
        return response(['url' => $url]);
    }
}
