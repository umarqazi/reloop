<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'avatar', 'status', 'quantity', 'unit', 'reward_points'
    ,'co2_emission_reduced','trees_saved','oil_saved','electricity_saved','natural_ores_saved','water_saved','landfill_space_saved'];

    /**
     * Method: getAvatarAttribute
     *
     * @param $value
     *
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if(!empty($value)){

            return env('APP_URL').'/storage/uploads/images/material-category/' . $value;
        }
    }
}
