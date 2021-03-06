<?php

namespace App\Forms\User;

use App\Forms\BaseForm;
use Illuminate\Validation\Rule;

/**
 * Class CreateForm
 *
 * @package   App\Forms\User
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 20, 2020
 * @project   reloop
 */
class CreateForm extends BaseForm
{
    public $organization_id;
    public $first_name;
    public $last_name;
    public $email;
    public $password;
    public $phone_number;
    public $birth_date;
    public $avatar;
    public $location;
    public $user_type;
    public $trips;
    public $reward_points;
    public $status;
    public $api_token;
    public $organization_name;
    public $no_of_employees;
    public $no_of_branches;
    public $city_id;
    public $sector_id;
    public $password_confirmation;
    public $district_id;
    public $latitude;
    public $longitude;
    public $hh_organization_name;
    public $reports;
    public $login_type;

    /**
     * CreateForm constructor.
     *
     */
    public function __construct()
    {
        $this->status = 0;
        $this->reports = 1;
        $this->login_type = 1;
        $this->api_token = str_random(50).strtotime('now');
        $this->signup_token = str_random(30);
    }

    /**
     * Method: toArray
     *
     * @return array
     */
    public function toArray()
    {
        return [
            'first_name'             => $this->first_name,
            'last_name'              => $this->last_name,
            'organization_id'        => $this->organization_id,
            'email'                  => $this->email,
            'password'               => $this->password,
            'password_confirmation'  => $this->password_confirmation,
            'phone_number'           => $this->phone_number,
            'hh_organization_name'   => $this->hh_organization_name,
            'birth_date'             => $this->birth_date,
            'avatar'                 => $this->avatar,
            'location'               => $this->location,
            'latitude'               => $this->latitude,
            'longitude'               => $this->longitude,
            'user_type'              => $this->user_type,
            'trips'                  => $this->trips,
            'reward_points'          => $this->reward_points,
            'organization_name'      => $this->organization_name,
            'no_of_employees'        => $this->no_of_employees,
            'no_of_branches'         => $this->no_of_branches,
            'city_id'                => $this->city_id,
            'sector_id'              => $this->sector_id,
            'district_id'            => $this->district_id
        ];
    }

    /**
     * Rules For CreateUserForm
     * @return array
     */
    public function rules()
    {
        return [
            'email' => 'required|email|unique:users',
            'password' => 'required|confirmed|min:8',
            'password_confirmation' => 'required',
            'phone_number' => 'required',
            'city_id' => 'required',
            'district_id' => 'required',
            'location' => 'required'
        ];

    }
}
