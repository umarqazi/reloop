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
}
