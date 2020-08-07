<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class CouponUsage extends Model
{
    /**
     * Property: fillable
     *
     * @var string[]
     */
    protected $fillable = ['coupon_id', 'user_id', 'no_of_usage'];
}
