<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class MaterialCategory extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'avatar', 'status'];

}
