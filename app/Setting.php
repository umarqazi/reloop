<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'keys', 'values'
    ];


}
