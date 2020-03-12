<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'price', 'description','status'
    ];

    /**
     * Method: category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
