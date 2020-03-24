<?php


namespace App\Services\Admin;


use App\Repositories\Admin\DistrictRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;

class DistrictService extends BaseService
{

    private $districtRepo;

    /**
     * DistrictService constructor.
     */

    public function __construct()
    {
        $districtRepo =  $this->getRepo(DistrictRepo::class);
        $this->districtRepo = new $districtRepo;
    }

}
