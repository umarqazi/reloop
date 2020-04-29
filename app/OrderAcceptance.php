<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class OrderAcceptance extends Model
{
    /**
     * @var array
     */
    protected $fillable = [
        'to','from','district_id'
    ];

    /**
     * Method: district
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function district()
    {
        return $this->belongsTo(District::class, 'district_id');
    }


}
