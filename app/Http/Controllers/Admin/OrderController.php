<?php

namespace App\Http\Controllers\Admin;

use Illuminate\Http\Request;
use App\Models\Order;
use App\Http\Controllers\Controller;
use App\Notifications\OrderDeliver;
use App\Exports\OrdersExport;
use App\Exports\OrdersMultipleExport;
use Maatwebsite\Excel\Facades\Excel;
use App\DataTables\OrdersDataTable;

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

    public function datatables(OrdersDataTable $ordersDataTable)
    {
        return $ordersDataTable->render('admin.orders.datatables');
    }

    public function delivery(Request $request, $id)
    {
        $order = Order::find($id);
        if ($order->is_shipped) {
            return response(['result' => false]);
        } else {
            $order->update(['is_shipped' => true]);
            $order->user->notify(new OrderDeliver());
            return response(['result' => true]);
            ;
        }
    }

    public function export()
    {
        return Excel::download(new OrdersExport, 'orders.xlsx');
    }

    public function exportByShipped()
    {
        return Excel::download(new OrdersMultipleExport, 'orders.xlsx');
    }
}
