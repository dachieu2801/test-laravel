<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\Category;
use App\Models\Coupon;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        // Lọc sản phẩm theo tên hoặc theo danh mục
        $query = Product::query();

        if ($request->has('search')) {
            $query->where('name', 'like', '%' . $request->search . '%');
        }

        if ($request->has('category_id') && $request->category_id) {
            $query->where('category_id', $request->category_id);
        }

        $products = $query->get();
        $categories = Category::all();
        return view('products.index', compact('products', 'categories'));
    }

    public function create()
    {
        $categories = Category::all();
        $coupons = Coupon::all(); 
        return view('products.create', compact('categories', 'coupons'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'coupon_ids' => 'nullable|array',
            'coupon_ids.*' => 'exists:coupons,id', 
        ]);

        $product = Product::create($validated);

        if ($request->has('coupon_ids')) {
            foreach ($request->coupon_ids as $coupon_id) {
                $product->couponConditions()->create([
                    'coupon_id' => $coupon_id,
                    'condition_type' => 'product',
                    'condition_value' => $product->id,
                ]);
            }
        }

        return redirect()->route('products.index');
    }


    public function edit($id)
    {
        $product = Product::find($id);
        $categories = Category::all();
        $coupons = Coupon::all();
        return view('products.edit', compact('product', 'categories', 'coupons'));
    }

    public function update(Request $request, $id)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
            'coupon_ids' => 'nullable|array',
            'coupon_ids.*' => 'exists:coupons,id',
        ]);

        $product = Product::find($id);
        $product->update($validated);

        $product->couponConditions()->where('condition_type', 'product')->delete();
        if ($request->has('coupon_ids')) {
            foreach ($request->coupon_ids as $coupon_id) {
                $product->couponConditions()->create([
                    'coupon_id' => $coupon_id,
                    'condition_type' => 'product',
                    'condition_value' => $product->id,
                ]);
            }
        } 

        return redirect()->route('products.index');
    }

    public function destroy($id)
    {
        Product::destroy($id);
        return redirect()->route('products.index');
    }
}
