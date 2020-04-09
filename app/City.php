<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
class City extends Model
{

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name','status' ];

    /**
     * Method: addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
      public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**
     * Method: orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }


    /**
     * Method: districts
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function districts()
    {
        return $this->hasMany(District::class);
    }
}
