<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCondition extends Model
{
    protected $fillable = ['coupon_id', 'condition_type', 'condition_value'];

    public function coupon()
    {
        return $this->belongsTo(Coupon::class);
    }
    
    public function product()
    {
        return $this->belongsTo(Product::class, 'condition_value', 'id');
    }

}
