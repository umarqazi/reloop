<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'per_day_max_orders_for_drivers', 'points_matrix'
    ];


}
