<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    /**
     * @var array
     */
    protected $fillable = ['name', 'description', 'status', 'type'];
    /**
     * @return HasMany
     */
    public function products() {
        return $this->hasMany(Product::class, 'category_id');
    }
    /**
     * @return HasMany
     */
    public function subscriptions() {
        return $this->hasMany(Subscription::class, 'category_id');
    }

}
