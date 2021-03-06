<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class District
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 09, 2020
 * @project   reloop
 */
class District extends Model
{
    protected $fillable = ['name','city_id','status','order_acceptance_days'];

    /**
     * Method: orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
