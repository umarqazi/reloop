<?php


namespace App\Repositories\Admin;

use App\Services\IUserType;
use App\User;
use Illuminate\Support\Collection;

class UserRepo extends BaseRepo
{
    private $getModel;
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $getModel = $this->getModel(User::class);
        $this->getModel = new $getModel;
    }

    public function all(): Collection
    {
        $users = $this->getModel::whereHas("roles", function($q) {
            $q->where("name", "!=", "admin");
        })->orderBy('email')->get();

        return $users;
    }

    /**
     * @param null $type
     * @param $role
     * @return mixed
     */
    public function getSelected($type)
    {
        return $this->getModel->where('user_type', $type)->get();
    }

    /**
     * @param $type
     * @param $city_id
     * @param $district_id
     * @return mixed
     */
    public function getDrivers($type,$city_id,$district_id)
    {
       $drivers =  $this->getModel->whereHas( 'addresses' , function ($query) use($city_id,$district_id) {
             $query->where('city_id', $city_id)->where('district_id',$district_id);
        })->where('user_type', $type)->get();

       return $drivers;
    }
}
