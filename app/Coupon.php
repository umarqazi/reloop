<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code', 'type', 'amount', 'max_usage_per_user', 'apply_for_user', 'coupon_user_type', 'list_user_id',
        'apply_for_category', 'coupon_category_type', 'list_category_id'
    ];

}
