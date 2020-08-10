<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserSubscription
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 05, 2020
 * @project   reloop
 */
class UserSubscription extends Model
{
    protected $fillable = [
        'user_id','subscription_id', 'start_date', 'end_date', 'trips', 'coupon', 'total'
    ];

    /**
     * Method: user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Method: subscription
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function subscription() {
        return $this->belongsTo(Subscription::class, 'subscription_id');
    }

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
