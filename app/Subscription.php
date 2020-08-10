<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class Subscription extends Model
{

    /**
     * @var array
     */
    protected $fillable = [
        'category_id', 'name', 'price', 'description', 'request_allowed', 'status', 'category_type',
        'avatar', 'product_for'
    ];

    /**
     * Method: category
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function category() {
        return $this->belongsTo(Category::class, 'category_id');
    }

    /**
     * Method: userTransaction
     * @return \Illuminate\Database\Eloquent\Relations\MorphMany
     */
    public function userTransaction()
    {
        return $this->morphMany(Transaction::class, 'transactionable');
    }

    /**
     * Method: userSubscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userSubscription()
    {
        return $this->hasMany(UserSubscription::class);
    }

    /**
     * Method: getAvatarAttribute
     *
     * @param $value
     *
     * @return string
     */
    public function getAvatarAttribute($value)
    {
        if(!empty($value)){

            return env('APP_URL').'/storage/uploads/images/subscription/' . $value;
        }
    }

}
