@extends('layouts.app')

@section('content')
<div class="p-4 bg-white shadow-lg">
    <h2 class="h2">Chi tiết đơn hàng #{{ $order->id }}</h2>

    <table class="table table-bordered">
        <thead>
            <tr>
                <th>Tên sản phẩm</th>
                <th>Số lượng</th>
                <th>Giá gốc</th>
                <th>Giá sau khuyến mãi</th>
                <th>Tổng</th>
            </tr>
        </thead>
        <tbody>
            @foreach($order->orderItems as $item)
            <tr>
                <td>{{ $item->product->name }}</td>
                <td>{{ $item->quantity }}</td>
                <td>{{ number_format($item->product->price, 2) }} VNĐ</td>
                <td>{{ number_format($item->price, 2) }} VNĐ</td>
                <td>{{ number_format($item->price * $item->quantity, 2) }} VNĐ</td>
            </tr>
            @endforeach
        </tbody>
    </table>

    <p><strong>Tổng tiền:</strong> {{ number_format($order->total_amount, 2) }} VNĐ</p>
</div>
@endsection
