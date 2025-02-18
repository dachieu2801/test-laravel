@extends('layouts.app')

@section('content')

<div class="p-4 bg-white shadow-lg">
    <h2 class="h2">Tạo đơn hàng mới</h2>

    <form action="{{ route('orders.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="user_id" class="form-label">Người dùng</label>
            <select name="user_id" class="form-select" required>
                @foreach($users as $user)
                    <option value="{{ $user->id }}">{{ $user->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="address" class="form-label">Địa chỉ</label>
            <input type="text" name="address" id="address" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="status" class="form-label">Trạng thái</label>
            <input type="text" name="status" id="status" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="product_ids[]" class="form-label">Sản phẩm</label>
            <select name="product_ids[]" class="form-select" multiple required>
                @foreach($products as $product)
                    <option value="{{ $product->id }}">{{ $product->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="quantities[]" class="form-label">Số lượng</label>
            <input type="text" name="quantities[]" class="form-control" required>
        </div>

        <div class="mb-3">
            <label for="coupon_ids[]" class="form-label">Khuyến mãi</label>
            <select name="coupon_ids[]" class="form-select" multiple>
                @foreach($coupons as $coupon)
                    <option value="{{ $coupon->id }}">{{ $coupon->name }}</option>
                @endforeach
            </select>
        </div>

        <button type="submit" class="btn btn-primary">Tạo đơn hàng</button>
    </form>
</div>

@endsection
