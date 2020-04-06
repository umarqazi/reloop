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

    /**
     * Method: donationProducts
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function donationProducts()
    {
        return $this->hasMany(DonationProduct::class);
    }
}
