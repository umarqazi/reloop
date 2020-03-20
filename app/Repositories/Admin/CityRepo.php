<?php


namespace App\Repositories\Admin;


use App\Repositories\Admin\BaseRepo;
use App\City;

class CityRepo extends BaseRepo
{
    /**
     * CityRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(City::class);
    }

    /**
     * @param string $name
     * @return mixed
     */
    public function findByName(string $name)
    {
        return $this->all()->where('name',$name)->first();
    }

}
