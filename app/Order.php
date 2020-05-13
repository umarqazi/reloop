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
        'user_id','driver_id', 'supervisor_id', 'order_number', 'subtotal', 'redeem_points', 'coupon_discount', 'total',
        'first_name', 'last_name', 'email', 'organization_name', 'phone_number', 'location', 'latitude', 'longitude',
        'city', 'district','status','delivery_date','driver_trip_status'
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

    /**
     * Method: user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Method: driver
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }


    /**

     * Method: orderItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }
}
