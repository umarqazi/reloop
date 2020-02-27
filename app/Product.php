<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'price', 'description', 'avatar','status'
    ];

    /**
     * @return BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
