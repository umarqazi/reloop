<?php


namespace App\Repositories\Admin;


use App\District;

class DistrictRepo extends BaseRepo
{
    private $getModel;

    /**
     * DistrictRepo constructor.
     */
    public function __construct()
    {
        $getModel = $this->getModel(District::class);
        $this->getModel = new $getModel;
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
