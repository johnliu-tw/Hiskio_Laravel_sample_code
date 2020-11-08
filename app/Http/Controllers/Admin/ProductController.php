<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Http\Controllers\Controller;

class ProductController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataPerPage = 5;
        $productCount = Product::count();
        $productPages = ceil($productCount / $dataPerPage);
        $currentPage = isset($request->all()['page']) ? $request->all()['page'] : 1;
        $products = Product::orderBy('created_at', 'desc')
                       ->offset($dataPerPage * ($currentPage - 1))
                       ->limit($dataPerPage)

                       ->get();

        return view('admin.products.index', ['products' => $products,
                                           'productCount' => $productCount,
                                           'productPages' => $productPages]);
    }
}
