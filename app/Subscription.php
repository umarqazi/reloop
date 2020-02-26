<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'price', 'description', 'avatar', 'request_allowed', 'status'
    ];
}
