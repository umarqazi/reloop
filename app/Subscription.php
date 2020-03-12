<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'category_id','stripe_product_id', 'name', 'price', 'description', 'request_allowed', 'status','category_type'
    ];

    /**
     * Method: category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

}
