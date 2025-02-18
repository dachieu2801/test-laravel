@extends('layouts.app')

@section('title', 'Coupon List')

@section('content')
    <h1 class="mb-4">Coupon List</h1>

    <a href="{{ route('coupons.create') }}" class="btn btn-success mb-3">Add New Coupon</a>

    <form action="{{ route('coupons.index') }}" method="GET" class="mb-4 row g-3">
        <div class="col-md-3">
            <input type="text" name="name" placeholder="Search by name" class="form-control" value="{{ request()->name }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="start_date" class="form-control" value="{{ request()->start_date }}">
        </div>
        <div class="col-md-3">
            <input type="date" name="end_date" class="form-control" value="{{ request()->end_date }}">
        </div>
        <div class="col-md-3">
            <button type="submit" class="btn btn-primary">Filter</button>
        </div>
    </form>

    <table class="table table-bordered table-striped">
        <thead>
            <tr>
                <th>#</th>
                <th>Name</th>
                <th>Type</th>
                <th>Value</th>
                <th>Start Date</th>
                <th>End Date</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($coupons as $coupon)
                <tr>
                    <td>{{ $coupon->id }}</td>
                    <td>{{ $coupon->name }}</td>
                    <td>{{ $coupon->type }}</td>
                    <td>{{ $coupon->value }}</td>
                    <td>{{ $coupon->start_date }}</td>
                    <td>{{ $coupon->end_date }}</td>
                    <td>
                        <a href="{{ route('coupons.edit', $coupon->id) }}" class="btn btn-sm btn-primary">Edit</a>
                        <form action="{{ route('coupons.destroy', $coupon->id) }}" method="POST" class="d-inline">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-sm btn-danger" onclick="return confirm('Are you sure?')">Delete</button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
@endsection
