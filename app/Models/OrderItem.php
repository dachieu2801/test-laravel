<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = ['order_id', 'product_id', 'unit_price', 'quantity', 'price', 'final_price', 'coupon_id'];
}
