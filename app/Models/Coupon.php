<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{
    protected $fillable = ['name', 'type', 'value', 'start_date', 'end_date', 'priority'];

    public function conditions()
    {
        return $this->hasMany(CouponCondition::class);
    }


    public function products()
    {
        return $this->belongsToMany(Product::class, 'coupon_conditions', 'coupon_id', 'condition_value')
                    ->where('condition_type', 'product');
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class, 'coupon_id');
    }
}
