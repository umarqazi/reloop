<?php


namespace App\Services\Admin;


use App\Repositories\Admin\CityRepo;
use App\Repositories\Admin\DistrictRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;

class CityService extends BaseService
{

    private $cityRepo;
    private $districtRepo;

    /**
     * CityService constructor.
     */

    public function __construct(DistrictRepo $districtRepo)
    {
        $cityRepo =  $this->getRepo(CityRepo::class);
        $this->cityRepo = new $cityRepo;
        $this->districtRepo = $districtRepo;
    }

    public function getRelatedDistricts($id){
       return $this->districtRepo->getRelatedDistricts($id);
    }
}
