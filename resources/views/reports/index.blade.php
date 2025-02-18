@extends('layouts.app')

@section('content')
<div class="container my-5">
    <h1 class="text-center mb-4">Báo cáo tổng hợp</h1>

    <!-- Tổng hợp doanh thu bán hàng -->
    <div class="card mb-4">
        <div class="card-header bg-primary text-white">
            <h2 class="h5">Doanh thu bán hàng</h2>
        </div>
        <div class="card-body">
            <p><strong>Tổng doanh thu:</strong> {{ number_format($totalRevenue, 2) }} VNĐ</p>
            <p><strong>Tổng số đơn hàng:</strong> {{ $totalOrders }}</p>
            <p><strong>Giá trị trung bình trên mỗi đơn hàng:</strong> {{ number_format($averageOrderValue, 2) }} VNĐ</p>
        </div>
    </div>

    <!-- Tổng hợp số lượng sản phẩm bán ra theo từng nhóm -->
    <div class="card mb-4">
        <div class="card-header bg-success text-white">
            <h2 class="h5">Số lượng sản phẩm bán ra theo nhóm</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Danh mục</th>
                        <th>Số lượng bán ra</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($productsByCategory as $category)
                        <tr>
                            <td>{{ $category->name }}</td>
                            <td>{{ $category->total_sold ?? 0 }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>

    <!-- Báo cáo hiệu quả của từng chương trình khuyến mãi -->
    <div class="card mb-4">
        <div class="card-header bg-warning text-dark">
            <h2 class="h5">Hiệu quả của chương trình khuyến mãi</h2>
        </div>
        <div class="card-body">
            <table class="table table-bordered">
                <thead class="table-dark">
                    <tr>
                        <th>Tên khuyến mãi</th>
                        <th>Số đơn hàng áp dụng</th>
                        <th>Doanh thu tạo ra</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($couponsReport as $coupon)
                        <tr>
                            <td>{{ $coupon->name }}</td>
                            <td>{{ $coupon->total_orders }}</td>
                            <td>{{ number_format($coupon->total_revenue, 2) }} VNĐ</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>
@endsection
