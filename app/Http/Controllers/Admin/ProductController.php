<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Imports\ProductsImport;
use App\Http\Controllers\Controller;
use Maatwebsite\Excel\Facades\Excel;

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

    public function uploadImage(Request $request)
    {
        $file = $request->file('product_image');
        $productId = $request->input('product_id', null);
        if (is_null($productId)) {
            return redirect()->back()->withErrors(['msg' => '參數錯誤']);
        }
        $product = Product::find($productId);
        $path = $file->store('public/images');
        $product->images()->create([
            'filename'        => $file->getClientOriginalName(),
            'path'            => $path,
        ]);

        return redirect()->back();
    }

    public function import(Request $request)
    {
        $file = $request->file('excel');
        Excel::import(new ProductsImport, $file);
        
        return redirect()->back();
    }
}
