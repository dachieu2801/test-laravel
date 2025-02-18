@extends('layouts.app')

@section('title', 'Create Coupon')

@section('content')
<div class="mb-5">
    <h1>Create New Coupon</h1>

    <form action="{{ route('coupons.store') }}" method="POST">
        @csrf
        <div class="mb-3">
            <label for="name" class="form-label">Coupon Name</label>
            <input type="text" name="name" class="form-control" id="name" required>
        </div>
        <div class="mb-3">
            <label for="type" class="form-label">Type</label>
            <select name="type" class="form-select" id="type" required>
                <option value="percentage">Percentage</option>
                <option value="amount">Amount</option>
                <option value="fix_price">Fix Price</option>
            </select>
        </div>
        <div class="mb-3">
            <label for="value" class="form-label">Value</label>
            <input type="number" name="value" class="form-control" id="value" step="0.01" required>
        </div>
        <div class="mb-3">
            <label for="start_date" class="form-label">Start Date</label>
            <input type="date" name="start_date" class="form-control" id="start_date">
        </div>
        <div class="mb-3">
            <label for="end_date" class="form-label">End Date</label>
            <input type="date" name="end_date" class="form-control" id="end_date">
        </div>

        <hr>
        <h4>Conditions</h4>
        <div id="condition-container">
            <div class="row mb-3">
                <div class="col">
                    <select name="condition_type[]" class="form-select" onchange="updateConditionValue(this)">
                        <option value="">Select Condition Type</option>
                        <option value="category">Category</option>
                        <option value="membership">Membership</option>
                        <option value="product">Product</option>
                    </select>
                </div>
                <div class="col">
                    <select name="condition_value[]" class="form-select" id="condition_value_0">
                        <option value="">Select Condition Value</option>
                    </select>
                </div>
            </div>
        </div>
        <button type="button" class="btn btn-secondary" onclick="addCondition()">Add Condition</button>

        <hr>
        <button type="submit" class="btn btn-primary">Create Coupon</button>
    </form>
</div>

    <script>
        // Add condition row dynamically
        function addCondition() {
            var container = document.getElementById('condition-container');
            var index = container.getElementsByClassName('row').length;
            var newCondition = `
                <div class="row mb-3">
                    <div class="col">
                        <select name="condition_type[]" class="form-select" onchange="updateConditionValue(this)">
                            <option value="">Select Condition Type</option>
                            <option value="category">Category</option>
                            <option value="membership">Membership</option>
                            <option value="product">Product</option>
                        </select>
                    </div>
                    <div class="col">
                        <select name="condition_value[]" class="form-select" id="condition_value_${index}">
                            <option value="">Select Condition Value</option>
                        </select>
                    </div>
                </div>`;
            container.insertAdjacentHTML('beforeend', newCondition);
        }

        // Function to update condition_value options based on condition_type
        function updateConditionValue(selectElement) {
            var conditionValueSelect = selectElement.closest('.row').querySelector('select[name="condition_value[]"]');
            var conditionType = selectElement.value;
            var options = [];
            
            // Clear current options
            conditionValueSelect.innerHTML = `<option value="">Select Condition Value</option>`;

            if (conditionType === 'category') {
                @foreach ($categories as $category)
                    options.push(`<option value="{{ $category->id }}">{{ $category->name }}</option>`);
                @endforeach
            } else if (conditionType === 'membership') {
                options.push('<option value="member">Member</option>');
                options.push('<option value="silver">Silver</option>');
                options.push('<option value="gold">Gold</option>');
            } else if (conditionType === 'product') {
                @foreach ($products as $product)
                    options.push(`<option value="{{ $product->id }}">{{ $product->name }}</option>`);
                @endforeach
            }
            conditionValueSelect.innerHTML += options.join('');
        }
    </script>
@endsection
