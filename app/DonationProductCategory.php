<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationProductCategory extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'name', 'description', 'status', 'avatar'
    ];

    /**
     * Method: donationProducts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donationProducts()
    {
        return $this->hasMany(DonationProduct::class);
    }

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

            return env('APP_URL').'/storage/uploads/images/donation-category/' . $value;
        }
    }
}
