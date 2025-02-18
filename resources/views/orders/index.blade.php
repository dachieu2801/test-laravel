@extends('layouts.app')

@section('content')

<div class="p-4 bg-white shadow-lg">
    <h2 class="h2">Danh sách đơn hàng</h2>

    <!-- Form tìm kiếm -->
    <form action="{{ route('orders.index') }}" method="GET" class="mb-4">
        <div class="d-flex gap-2 mb-4">
            <!-- Tìm kiếm theo tên sản phẩm -->
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm" class="form-control" value="{{ request('search') }}">

            <!-- Tìm kiếm theo người dùng -->
            <select name="user_id" class="form-select">
                <option value="">Chọn người dùng</option>
                @foreach($users as $user)
                    <option value="{{ $user->id }}" @if(request('user_id') == $user->id) selected @endif>
                        {{ $user->name }}
                    </option>
                @endforeach
            </select>

            <!-- Tìm kiếm theo khoảng thời gian -->
            <input type="date" name="start_date" class="form-control" value="{{ request('start_date') }}">
            <input type="date" name="end_date" class="form-control" value="{{ request('end_date') }}">

            <button type="submit" class="btn btn-primary">Tìm kiếm</button>
        </div>
    </form>
    <!-- Hiển thị tổng hợp -->
    <div class="mb-3">
        <strong>Tổng đơn hàng:</strong> {{ $totalOrders }} <br>
        <strong>Tổng tiền:</strong> {{ number_format($totalAmount, 2) }} VNĐ <br>
        <strong>Trung bình mỗi đơn hàng:</strong> {{ number_format($averageAmount, 2) }} VNĐ
    </div>

    <!-- Bảng danh sách đơn hàng -->
    <table class="table">
        <thead>
            <tr>
                <th>Id đơn hàng </th>
                <th>Tên khách hàng </th>
                <th>Địa chỉ </th>
                <th>Tổng tiền đơn hàng</th>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Tổng tiền sản phẩm</th>
                <th>Khuyến mãi</th>
                <th>Giảm giá</th>
                <th>Tổng tiền sản phẩm</th>
            </tr>
        </thead>
        <tbody>
    @foreach($orders as $order)
        @php $firstItem = true; @endphp  <!-- Biến kiểm tra -->
        @foreach($order->orderItems as $item)
            <tr>
                @if($firstItem)
                    <!-- Gộp các trường của đơn hàng vào hàng đầu tiên của sản phẩm -->
                    <td rowspan="{{ $order->orderItems->count() }}">{{ $order->id }}</td>
                    <td rowspan="{{ $order->orderItems->count() }}">{{ $order->user->name }}</td>
                    <td rowspan="{{ $order->orderItems->count() }}">{{ $order->address }}</td>
                
                    <td rowspan="{{ $order->orderItems->count() }}">{{ number_format($order->total, 2) }} VNĐ</td>
                    @php $firstItem = false; @endphp  <!-- Đánh dấu đã hiển thị -->
                @endif
                <td >{{  $item->product->name }}</td>
                <td >{{ $item->quantity }} </td>
                <!-- Hiển thị thông tin sản phẩm -->
                <td>{{ number_format($item->price, 2) }} VNĐ</td>
                <td>{{ $item->coupon ? $item->coupon->name : 'Không có' }}</td>
                <td>{{ number_format($item->discount, 2) }} VNĐ</td>
                <td>{{ number_format($item->final_price, 2) }} VNĐ</td>
            </tr>
        @endforeach
    @endforeach
</tbody>
    </table>

    <a href="{{ route('orders.export') }}" class="btn btn-success">Xuất báo cáo</a>
</div>

@endsection
