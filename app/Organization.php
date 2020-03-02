<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Organization
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 20, 2020
 * @project   reloop
 */
class Organization extends Model
{
    protected $fillable = [
        'name', 'address', 'no_of_employees', 'no_of_branches', 'cities_operate_in'
    ];

    /**
     * @return HasMany
     */
    public function users() {
        return $this->hasMany(User::class, 'organization_id');
    }

}
