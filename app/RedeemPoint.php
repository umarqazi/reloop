<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class RedeemPoint extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['start','end','discount'];

}
