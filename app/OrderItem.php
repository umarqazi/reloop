<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class OrderItem
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 05, 2020
 * @project   reloop
 */
class OrderItem extends Model
{
    protected $fillable = ['user_id','order_id', 'product_id', 'price', 'quantity'];
}
