<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Categories extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'status', 'type'];

}
