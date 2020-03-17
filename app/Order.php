<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Order
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 05, 2020
 * @project   reloop
 */
class Order extends Model
{
    protected $fillable = [
        'user_id', 'order_number', 'subtotal', 'redeem_points', 'coupon_discount', 'total', 'first_name', 'last_name', 'email',
        'phone_number', 'location', 'latitude', 'longitude', 'city', 'district'
    ];

    /**
     * Method: userTransaction
     *
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function userTransaction()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }
}
