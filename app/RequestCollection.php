<?php

namespace App;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    /**
     * @var array
     */
    protected $fillable = [
        'user_id', 'request_id', 'material_category_id', 'category_name', 'weight'
    ];

    /**
     * Method: requests
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function requests()
    {
        return $this->hasMany(Request::class, 'id', 'request_id');
    }

    /**
     * Method: request
     * @return BelongsTo
     */
    public function request()
    {
        return $this->belongsTo(Request::class);
    }

    public function materialCategory()
    {
        return $this->belongsTo(MaterialCategory::class, 'material_category_id');
    }

    /**
     * Function user
     *
     * @return BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
