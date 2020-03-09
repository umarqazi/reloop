<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

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
        'name', 'no_of_employees', 'no_of_branches', 'sector_id'
    ];

    /**
     * @return HasMany
     */
    public function users() {
        return $this->hasMany(User::class, 'organization_id');
    }

    /**
     * Method: sector
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function sector()
    {
        return $this->belongsTo(Sector::class, 'sector_id');
    }

}
