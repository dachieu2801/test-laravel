@extends('layouts.app')

@section('content')

<div class="p-4 bg-white shadow-lg">
    <h2 class="h2">Danh sách sản phẩm</h2>
    <div class="d-flex mt-4 mb-4 gap-2">
        <form action="{{ route('products.index') }}" method="GET" class="d-flex gap-2">
            <input type="text" name="search" placeholder="Tìm kiếm sản phẩm" class="form-control" value="{{ request('search') }}">
            <select name="category_id" class="form-select">
                <option value="">Chọn danh mục</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}" @if(request('category_id') == $category->id) selected @endif>
                        {{ $category->name }}
                    </option>
                @endforeach
            </select>
            <button type="submit" class="btn btn-primary w-100">Tìm kiếm</button>
        </form>
    </div>

    <a href="{{ route('products.create') }}" class="btn btn-success mb-3">Thêm sản phẩm mới</a>

    <table class="table table-bordered table-hover">
        <thead class="table-light text-center">
            <tr>
                <th>Tên sản phẩm</th>
                <th>Mô tả</th>
                <th>Giá</th>
                <th>Danh mục</th>
                <th>Hành động</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($products as $product)
                <tr class="text-center">
                    <td>{{ $product->name }}</td>
                    <td>{{ $product->description }}</td>
                    <td>{{ number_format($product->price, 2) }} VNĐ</td>
                    <td>{{ $product->category->name }}</td>
                    <td>
                        <a href="{{ route('products.edit', $product->id) }}" class="text-primary">Sửa</a> |
                        <form action="{{ route('products.destroy', $product->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button  onclick="return confirm('Are you sure?')" type="submit" class="btn btn-link text-danger p-0 border-0">Xóa</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
