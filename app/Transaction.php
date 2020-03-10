<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class Transaction
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 05, 2020
 * @project   reloop
 */
class Transaction extends Model
{
    protected $fillable = ['user_id','transactionable_id', 'transactionable_type', 'price'];

    /**
     * Method: transactionable
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function transactionable()
    {
        return $this->morphTo();
    }
}
