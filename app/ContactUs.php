<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class ContactUs
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 01, 2020
 * @project   reloop
 */
class ContactUs extends Model
{
    /**
     * Property: fillable
     *
     * @var array
     */
    protected $fillable = ['email','subject','message'];
}
