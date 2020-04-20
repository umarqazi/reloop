<?php

namespace App;

use Illuminate\Notifications\Notifiable;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use Notifiable;
    use HasRoles;

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','organization_id','phone_number','birth_date', 'hh_organization_name',
        'avatar','user_type','trips','reward_points','status','verified_at', 'signup_token', 'api_token','stripe_customer_id',
        'login_type'
    ];

    /**
     *
     * @var array
     */
    protected $hidden = [
        'password', 'remember_token',
    ];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    /**
     * Method: organization
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function organization()
    {
        return $this->belongsTo(Organization::class, 'organization_id');
    }

    /**
     * Method: addresses
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    /**

     * Method: orders
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

     /** Method: userSubscription
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany
     */
    public function userSubscription()
    {
        return $this->hasMany(UserSubscription::class);
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


    public function getAvatarAttribute($value)
    {
        if(!empty($value)){

            return env('APP_URL').'/storage/uploads/images/profile-pictures/' . $value;
        }
    }

    /**
     * Method: currentLocation
     * @return \Illuminate\Database\Eloquent\Relations\HasOne
     */
    public function currentLocation()
    {
        return $this->hasOne(DriverCurrentLocation::class, 'driver_id', 'id');
    }
}
