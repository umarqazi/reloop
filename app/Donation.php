<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Donation
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 06, 2020
 * @project   reloop
 */
class Donation extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'donation_product_id', 'redeemed_points'
    ];

    /**
     * Method: user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Method: donationProduct
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function donationProduct()
    {
        return $this->belongsTo(DonationProduct::class,'donation_product_id');
    }
}
