<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class UserCard
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Aug 07, 2020
 * @project   reloop
 */
class UserCard extends Model
{
    protected $fillable = [
        'user_id', 'card_number', 'signature', 'expiry_date', 'merchant_reference', 'token_name', 'card_security_code',
        'default'
    ];

    /**
     * Method: user
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
