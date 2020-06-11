<?php


namespace App\Services\Admin;


use App\Repositories\Admin\CityRepo;
use App\Repositories\Admin\CollectionRequestRepo;
use App\Repositories\Admin\DistrictRepo;
use App\Repositories\Admin\MaterialCategoryRepo;
use App\Repositories\Admin\RequestCollectionRepo;
use App\Repositories\Admin\UserRepo;
use App\Repositories\Admin\OrderRepo;
use App\Services\Admin\BaseService;
use App\Services\EmailNotificationService;
use App\Services\IOrderStaus;
use App\Services\IUserType;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use phpDocumentor\Reflection\Types\Parent_;

class RequestCollectionService extends BaseService
{

    private $requestCollectionRepo;
    /**
     * RequestCollectionService constructor.
     */

    public function __construct(RequestCollectionRepo $requestCollectionRepo)
    {
        $requestCollectionRepo          =  $this->getRepo(RequestCollectionRepo::class);
        $this->requestCollectionRepo    = new $requestCollectionRepo;
    }

    /**
     * Method: calculateWeight
     *
     * @param $userId
     *
     * @return mixed
     */
    public function calculateWeight($userId)
    {
        return $this->requestCollectionRepo->calculateWeight($userId);
    }

}
