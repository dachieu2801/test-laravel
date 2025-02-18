<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\Coupon;
use App\Models\User;
use Illuminate\Http\Request;
use Maatwebsite\Excel\Facades\Excel;

class OrderController extends Controller
{
    public function index(Request $request)
    {

        $users = User::all();

        $orders = Order::with('orderItems.product', 'orderItems.coupon')
            ->when($request->search, function ($query) use ($request) {
                return $query->whereHas('orderItems.product', function ($q) use ($request) {
                    $q->where('name', 'like', '%' . $request->search . '%');
                });
            })
            ->when($request->user_id, function ($query) use ($request) {
                return $query->where('user_id', $request->user_id);
            })
            ->when($request->start_date && $request->end_date, function ($query) use ($request) {
                return $query->whereBetween('created_at', [$request->start_date, $request->end_date]);
            })
            ->get();

        // Tổng đơn hàng
        $totalOrders = $orders->count();
        
        // Tổng tiền
        $totalAmount = $orders->sum(function ($order) {
            return $order->orderItems->sum('final_price');
        });

        // Trung bình số tiền mỗi đơn hàng
        $averageAmount = $totalOrders ? $totalAmount / $totalOrders : 0;

        return view('orders.index', compact('orders', 'totalOrders', 'totalAmount', 'averageAmount', 'users'));
    }

    public function export(Request $request)
    {
        $orders = Order::with('orderItems.product', 'orderItems.coupon')
            ->when($request->search, function ($query) use ($request) {
                return $query->where('address', 'like', '%' . $request->search . '%');
            })
            ->get();
    
        $data = collect([ 
            [
                'Id đơn hàng', 'Tên khách hàng', 'Địa chỉ', 'Tổng tiền đơn hàng', 
                'Tên sản phẩm', 'Số lượng', 'Giá', 'Khuyến mãi', 'Giảm giá', 'Tổng tiền sản phẩm'
            ]
        ])->merge(
            $orders->map(function ($order) {
                return $order->orderItems->map(function ($item) use ($order) {
                    return [
                        'Id đơn hàng' => $order->id,
                        'Tên khách hàng' => $order->user->name,
                        'Địa chỉ' => $order->address,
                        'Tổng tiền đơn hàng' => number_format($order->total, 2),
    
                        'Tên sản phẩm' => $item->product->name,
                        'Số lượng' => $item->quantity,
                        'Giá' => number_format($item->unit_price, 2),
                        'Khuyến mãi' => $item->coupon ? $item->coupon->name : 'Không có',
                        'Giảm giá' => number_format($item->discount, 2),
                        'Tổng tiền sản phẩm' => number_format($item->final_price, 2),
                    ];
                });
            })->flatten(1)
        );
    
        // Tải file Excel với dữ liệu đã được thêm tiêu đề
        return Excel::download(new \App\Exports\OrdersExport($data), 'orders.xlsx');
    }

}

