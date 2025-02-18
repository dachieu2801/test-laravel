<?php
namespace App\Http\Controllers;

use App\Models\Coupon;
use App\Models\Category;
use App\Models\Product;
use App\Models\User;
use Illuminate\Http\Request;

class CouponController extends Controller
{
    public function index(Request $request)
    {
        $query = Coupon::query();

        // Filter theo tên
        if ($request->has('name') && $request->name != '') {
            $query->where('name', 'like', '%' . $request->name . '%');
        }

        // Filter theo ngày
        if ($request->has('start_date') && $request->has('end_date')) {
            $query->whereBetween('start_date', [$request->start_date, $request->end_date]);
        }

        $coupons = $query->get();

        return view('coupons.index', compact('coupons'));
    }

    public function create()
    {
        $categories = Category::all();
        $products = Product::all();
        $memberships = User::all()->pluck('membership_type', 'id');
        return view('coupons.create', compact('categories', 'products', 'memberships'));
    }
    
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required|in:percentage,amount,fix_price',
            'value' => 'required|numeric|min:0',
            'name' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);
    
        $coupon = Coupon::create($request->only(['name', 'type', 'value', 'start_date', 'end_date']));
    
        if ($request->condition_type) {
            foreach ($request->condition_type as $index => $type) {
                if ($type && $request->condition_value[$index]) {
                    $coupon->conditions()->create([
                        'condition_type' => $type,
                        'condition_value' => $request->condition_value[$index],
                    ]);
                }
            }
        }
    
        return redirect()->route('coupons.index')->with('success', 'Coupon created successfully.');
    }
    
   
    public function edit($id)
    {
        $coupon = Coupon::with('conditions')->findOrFail($id);
        $categories = Category::all();
        $products = Product::all();
        $memberships = ['member', 'silver', 'gold'];
        return view('coupons.edit', compact('coupon', 'categories', 'products', 'memberships'));
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'type' => 'required|in:percentage,amount,fix_price',
            'value' => 'required|numeric|min:0',
            'name' => 'required',
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
        ]);

        $coupon = Coupon::findOrFail($id);
        $coupon->update($request->only(['name', 'type', 'value', 'start_date', 'end_date']));

        $coupon->conditions()->delete();
        if ($request->condition_type) {
            foreach ($request->condition_type as $index => $type) {
                if ($type && $request->condition_value[$index]) {
                    $coupon->conditions()->create([
                        'condition_type' => $type,
                        'condition_value' => $request->condition_value[$index],
                    ]);
                }
            }
        }

        return redirect()->route('coupons.index')->with('success', 'Coupon updated successfully.');
    }

    public function destroy($id)
    {
        $coupon = Coupon::findOrFail($id);
        $coupon->delete();

        return redirect()->route('coupons.index')->with('success', 'Coupon deleted successfully.');
    }
}
