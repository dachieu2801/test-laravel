<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        // Thêm dữ liệu vào bảng users
        DB::table('users')->insert([
            ['name' => 'Nguyen Van A', 'email' => 'vana@example.com', 'phone' => '0912345678', 'password' => bcrypt('password'), 'membership_type' => 'member', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Tran Thi B', 'email' => 'thib@example.com', 'phone' => '0987654321', 'password' => bcrypt('password'), 'membership_type' => 'gold', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Le Thi C', 'email' => 'thic@example.com', 'phone' => '0912345679', 'password' => bcrypt('password'), 'membership_type' => 'silver', 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Pham Minh D', 'email' => 'minhd@example.com', 'phone' => '0987654322', 'password' => bcrypt('password'), 'membership_type' => 'member', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Thêm dữ liệu vào bảng categories
        DB::table('categories')->insert([
            ['id' => 1, 'name' => 'Electronics', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 2,'name' => 'Fashion', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 3, 'name' => 'Home & Kitchen', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
            ['id' => 4, 'name' => 'Sports', 'parent_id' => null, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Thêm dữ liệu vào bảng products
        DB::table('products')->insert([
            ['name' => 'Smartphone', 'description' => 'Latest smartphone', 'price' => 500.00, 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Laptop', 'description' => 'High-end laptop', 'price' => 1200.00, 'category_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'T-Shirt', 'description' => 'Cool T-shirt', 'price' => 20.00, 'category_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Blender', 'description' => 'High-power kitchen blender', 'price' => 80.00, 'category_id' => 3, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Football', 'description' => 'Premium leather football', 'price' => 30.00, 'category_id' => 4, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Thêm dữ liệu vào bảng coupons
        DB::table('coupons')->insert([
            ['name' => 'Discount 10%', 'type' => 'percentage', 'value' => 10.00, 'priority' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Fixed 50k Off', 'type' => 'amount', 'value' => 50.00, 'priority' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['name' => 'Silver Member 5%', 'type' => 'percentage', 'value' => 5.00, 'priority' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Thêm dữ liệu vào bảng coupon_conditions
        DB::table('coupon_conditions')->insert([
            ['coupon_id' => 1, 'condition_type' => 'category', 'condition_value' => 'Electronics', 'created_at' => now(), 'updated_at' => now()],
            ['coupon_id' => 2, 'condition_type' => 'membership', 'condition_value' => 'gold', 'created_at' => now(), 'updated_at' => now()],
            ['coupon_id' => 3, 'condition_type' => 'membership', 'condition_value' => 'silver', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Thêm dữ liệu vào bảng orders
        DB::table('orders')->insert([
            ['phone' => '0912345678', 'address' => '123 Main St', 'user_id' => 1, 'user_type' => 'gold', 'total_amount' => 500.00, 'total' => 450.00, 'status' => 'pending', 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '0987654321', 'address' => '456 Elm St', 'user_id' => 2, 'user_type' => 'silver', 'total_amount' => 1000.00, 'total' => 1190.00, 'status' => 'completed', 'created_at' => now(), 'updated_at' => now()],
            ['phone' => '0912345679', 'address' => '789 Oak St', 'user_id' => 3, 'user_type' => 'silver', 'total_amount' => 1200.00, 'total' => 35.00, 'status' => 'shipped', 'created_at' => now(), 'updated_at' => now()],
        ]);

        // Thêm dữ liệu vào bảng order_items
        DB::table('order_items')->insert([
            ['order_id' => 1, 'product_id' => 1, 'discount' => 50.00, 'quantity' => 1, 'unit_price' => 500.00, 'price' => 500.00, 'final_price' => 450.00, 'coupon_id' => 1, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 2, 'product_id' => 2, 'discount' => 10.00, 'quantity' => 1, 'unit_price' => 1200.00, 'price' => 1200.00, 'final_price' => 1190.00, 'coupon_id' => 2, 'created_at' => now(), 'updated_at' => now()],
            ['order_id' => 3, 'product_id' => 3, 'discount' => 5.00, 'quantity' => 2, 'unit_price' => 20.00, 'price' => 40.00, 'final_price' => 35.00, 'coupon_id' => 3, 'created_at' => now(), 'updated_at' => now()],
        ]);
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        DB::table('order_items')->truncate();
        DB::table('orders')->truncate();
        DB::table('coupon_conditions')->truncate();
        DB::table('coupons')->truncate();
        DB::table('products')->truncate();
        DB::table('categories')->truncate();
        DB::table('users')->truncate();
    }
};
