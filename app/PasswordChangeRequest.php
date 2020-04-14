<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class PasswordChangeRequest
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 13, 2020
 * @project   reloop
 */
class PasswordChangeRequest extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['user_id', 'email', 'status'];

    /**
     * Method: user
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user() {
        return $this->belongsTo(User::class, 'user_id');
    }
}
