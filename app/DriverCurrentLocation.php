<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class DriverCurrentLocation
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 17, 2020
 * @project   reloop
 */
class DriverCurrentLocation extends Model
{
    protected $fillable = ['driver_id', 'latitude', 'longitude'];

    /**
     * Method: driver
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function driver()
    {
        return $this->belongsTo(User::class, 'driver_id');
    }
}
