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
        'user_id', 'driver_id', 'supervisor_id', 'request_number', 'collection_date', 'collection_type', 'reward_points',
        'status', 'first_name', 'last_name', 'organization_name', 'phone_number', 'location', 'latitude', 'longitude',
        'city_id', 'district_id', 'street', 'question_1', 'answer_1', 'question_2', 'answer_2','confirm','driver_trip_status',
        'user_comments', 'additional_comments'
    ];

    /**
     * Method: requestCollection
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requestCollection()
    {
        return $this->hasMany(RequestCollection::class);
    }

    /**
     * @param $collection
     * @return int
     */
    public function weight($collection)
    {
        $weight = 0;
        foreach ($collection as $item)
        {
            $weight += $item->weight;
        }

        return $weight;
    }

    /**
     * Method: user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
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
     * Method: city
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function city()
    {
        return $this->belongsTo(City::class, 'city_id');
    }

    /**
     * Method: district
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }
}
