<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationProductCategory extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name','description','status'
    ];
    
}
