<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * Class RequestCollection
 *
 * @package   App
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 25, 2020
 * @project   reloop
 */
class RequestCollection extends Model
{
    protected $fillable = [
        'user_id', 'request_id', 'material_category_id', 'category_name', 'weight'
    ];

    /**
     * Method: requests
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(Request::class);
    }

    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class);
    }
}
