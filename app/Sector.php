<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Sector extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'created_at', 'updated_at'];

    /**
     * @return HasMany
     */
    public function organizations() {
        return $this->hasMany(Organization::class, 'sector_id');
    }
}
