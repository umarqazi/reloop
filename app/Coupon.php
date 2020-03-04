<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Coupon extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['code','type','amount'];

}
