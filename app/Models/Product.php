<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    protected $fillable = ['name', 'description', 'price', 'category_id'];

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function couponConditions()
    {
        return $this->hasMany(CouponCondition::class, 'condition_value', 'id')->where('condition_type', 'product');
    }

    public function coupons()
    {
        return $this->belongsToMany(Coupon::class, 'coupon_conditions', 'condition_value', 'coupon_id')
                    ->where('condition_type', 'product');
    }

}
