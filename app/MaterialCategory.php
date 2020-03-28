<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'avatar', 'status', 'quantity', 'unit', 'reward_points'];

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
