<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class EnvironmentalStatsDescription
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     May 14, 2020
 * @project   reloop
 */
class EnvironmentalStatsDescription extends Model
{
    protected $fillable = ['title', 'description'];
}
