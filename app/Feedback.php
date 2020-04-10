<?php

namespace App;
use Illuminate\Database\Eloquent\Model;

/**
 * Class Feedback
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 11, 2020
 * @project   reloop
 */
class Feedback extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['orderable_id','orderable_type', 'question', 'answer', 'additional_comments'];

    /**
     * Method: orderable
     * @return \Illuminate\Database\Eloquent\Relations\MorphTo
     */
    public function orderable()
    {
        return $this->morphTo();
    }
}
