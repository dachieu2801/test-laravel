<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Product;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;
use DB;

class ReportController extends Controller
{
    public function index(Request $request)
    {
        // Tổng hợp doanh thu bán hàng
        $totalRevenue = Order::sum('total');
        $totalOrders = Order::count();
        $averageOrderValue = $totalOrders > 0 ? $totalRevenue / $totalOrders : 0;

        // Tổng hợp số lượng sản phẩm bán ra theo từng nhóm (categories)
        $productsByCategory = Category::withCount(['products as total_sold' => function ($query) {
            $query->select(DB::raw('SUM(order_items.quantity)'))
                  ->join('order_items', 'products.id', '=', 'order_items.product_id');
        }])->get();

        // Báo cáo hiệu quả của từng chương trình khuyến mãi
        $couponsReport = Coupon::withCount(['orderItems as total_orders' => function ($query) {
            $query->distinct('order_id');
        }])->withSum('orderItems as total_revenue', 'final_price')->get();

        return view('reports.index', compact(
            'totalRevenue', 
            'totalOrders', 
            'averageOrderValue',
            'productsByCategory',
            'couponsReport'
        ));
    }
}
