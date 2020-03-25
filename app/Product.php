<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Product extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'price', 'description','status','avatar'
    ];

    /**
     * Method: category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**

     * Method: orderItems
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

}
