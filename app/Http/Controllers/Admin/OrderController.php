<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Models\Order;
use App\Http\Controllers\Controller;

class OrderController extends Controller
{
    /**
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $dataPerPage = 5;
        $orderCount = Order::whereHas('orderItems')->count();
        $orderPages = ceil($orderCount / $dataPerPage);
        $currentPage = isset($request->all()['page']) ? $request->all()['page'] : 1;
        $orders = Order::with(['orderItems', 'orderItems.product'])
                       ->orderBy('created_at', 'desc')
                       ->offset($dataPerPage * ($currentPage - 1))
                       ->limit($dataPerPage)
                       ->whereHas('orderItems')
                       ->get();

        return view('admin.orders.index', ['orders' => $orders,
                                           'orderCount' => $orderCount,
                                           'orderPages' => $orderPages]);
    }
}
