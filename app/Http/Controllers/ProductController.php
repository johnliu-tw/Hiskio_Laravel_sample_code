<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Redis;
use App\Models\Product;
use App\Http\Services\ShortUrlService;
use App\Http\Services\AuthService;

class ProductController extends Controller
{
    public function __construct(ShortUrlService $shortUrlService, AuthService $authService)
    {
        $this->shortUrlService = $shortUrlService;
        $this->authService = $authService;
    }
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
        // 假設有查看特定使用者分享次數的邏輯
        // eg: auth()->user()->checkShareCount...
        $this->authService->fakeReturn();
        $url = $this->shortUrlService->makeSortUrl("http://localhost:3000/products/$id");
        return response(['url' => $url]);
    }
}
