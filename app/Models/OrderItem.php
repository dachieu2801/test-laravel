<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'order_id', 'product_id', 'quantity', 'unit_price', 'price', 'final_price', 'discount', 'coupon_id'
    ];

    // Quan hệ với Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    // Quan hệ với Coupon (Khuyến mãi)
    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
}
