<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CouponCondition extends Model
{
    protected $fillable = ['coupon_id', 'condition_type', 'condition_value'];
}
