<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Address
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 02, 2020
 * @project   reloop
 */
class Address extends Model
{
    /**
     * Property: fillable
     * @var array
     */
    protected $fillable = [
        'user_id', 'city_id', 'location', 'type', 'no_of_bedrooms', 'no_of_occupants', 'district_id', 'street', 'floor',
        'unit_number','default'
    ];

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
     * Method: city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }
}
