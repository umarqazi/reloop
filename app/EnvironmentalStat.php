<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class EnvironmentalStat
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 15, 2020
 * @project   reloop
 */
class EnvironmentalStat extends Model
{
    protected $fillable = [
        'user_id', 'co2_emission_reduced', 'trees_saved', 'oil_saved', 'electricity_saved',
        'water_saved', 'landfill_space_saved'
    ];
}
