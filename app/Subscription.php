<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'category_id','stripe_product_id', 'name', 'price', 'description', 'avatar', 'request_allowed', 'status'
    ];

    /**
     * @return BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
