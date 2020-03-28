<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Request
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 25, 2020
 * @project   reloop
 */
class Request extends Model
{
    protected $fillable = [
        'user_id', 'driver_id', 'request_number', 'collection_date', 'collection_type', 'reward_points', 'status',
        'first_name', 'last_name', 'phone_number', 'location', 'latitude', 'longitude', 'city', 'district', 'street',
        'question_1', 'answer_1', 'question_2', 'answer_2'
    ];
}
