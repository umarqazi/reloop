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

    public $playerId = [];
    public $message;
    public $orderNumber;
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'first_name', 'last_name', 'email', 'password','organization_id','phone_number','birth_date', 'hh_organization_name',
        'avatar','user_type','trips','reward_points','status','verified_at', 'signup_token', 'api_token',
        'login_type', 'reports', 'password_reset_token', 'player_id', 'gender'
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

    public function userCards()
    {
        return $this->hasMany(UserCard::class);
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

    /**
     * Method: routeNotificationForOneSignal
     *
     * @return array
     */
    public function routeNotificationForOneSignal()
    {
        return $this->playerId;
    }

    /**
     * Method: setPlayerId
     *
     * @param array $value
     *
     * @return void
     */
    public function setPlayerId(array $value)
    {
        $this->playerId = $value;
    }

    /**
     * Method: setLoginSuccessMsg
     *
     * @param $message
     *
     * @return void
     */
    public function setLoginSuccessMsg($message)
    {
        $this->message = $message;
    }

    /**
     * Method: setOrderNumber
     *
     * @param $orderNumber
     *
     * @return void
     */
    public function setOrderNumber($orderNumber)
    {
        $this->orderNumber = $orderNumber;
    }

    /**
     * Accessor for player id column.
     *
     * @param  $playerId
     *
     * @return  array|false|string[]
     */
    public function getPlayerIdAttribute($playerId)
    {
        return (!empty($playerId) ? explode(',', $playerId) : []);
    }

    /**
     * Mutator for player id column.
     *
     * @param  $playerId
     */
    public function setPlayerIdAttribute($playerId)
    {
        $this->attributes['player_id'] = is_array($playerId) ? implode(',', $playerId) : $playerId;
    }
}
