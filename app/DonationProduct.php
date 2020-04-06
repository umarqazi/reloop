<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class DonationProduct extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'redeem_points', 'description','status'
    ];

    /**
     * Method: category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category()
    {
        return $this->belongsTo(DonationProductCategory::class, 'category_id');
    }
}
