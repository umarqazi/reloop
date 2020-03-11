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
    protected $fillable = ['user_id','subscription_id', 'stripe_subscription_id', 'start_date', 'end_date', 'trips'];
}
