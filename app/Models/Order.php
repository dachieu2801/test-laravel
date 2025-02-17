<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $fillable = ['phone', 'address', 'user_id', 'user_type', 'total_amount', 'total', 'status'];
}
