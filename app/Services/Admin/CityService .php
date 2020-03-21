<?php


namespace App\Services\Admin;


use App\Repositories\Admin\CityRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;

class CityService extends BaseService
{

    private $cityRepo;

    /**
     * CityService constructor.
     */

    public function __construct()
    {
        $cityRepo =  $this->getRepo(CityRepo::class);
        $this->cityRepo = new $cityRepo;
    }
}
