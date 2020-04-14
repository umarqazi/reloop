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
     * @return Mixed
     */
    public function getOrders($city,$district)
    {
        $orders = $this->collectionRequestRepo->getOrders($city,$district);
        return $orders;
    }

    /**
     * @param $request
     * @param $id
     * @return mixed
     */
    public function upgrade($request, $id)
    {
        $order = array(
            'driver_id'        => $request['driver_id'],
            'status'           => IOrderStaus::DRIVER_ASSIGNED,
        );

        $orderAssignment =  parent::update($id, $order);

        $order = $this->findById($id);

        if($orderAssignment){

            return true ;
        }

        else {
            return false;
        }
    }

    /**
     * @param $date
     * @param $order_id
     * @return mixed
     */
    public function availableDrivers($date,$order_id){
        $request = $this->findById($order_id);

        $city = $request->city ;
        $district = $request->district;

        $city_id = $this->cityRepo->findByName($city)->id ;
        $district_id = $this->districtRepo->findByName($district)->id;

        $drivers = $this->userRepo->getDrivers(IUserType::DRIVER,$city_id,$district_id);

        $availableDrivers = $this->collectionRequestRepo->availableDrivers($drivers,$date);

        return $availableDrivers;
    }

    public function confirmRequest($id){
    $request = $this->findById($id);

    $rewardPoints = 0 ;
        foreach($request->requestCollection as $collection){
            $materialCategoryPoints  = $this->materialCategoryRepo->findByName($collection->category_name)->reward_points;
            $rewardPoints += $materialCategoryPoints * $collection->weight ;
        }
        $confirm  = array(
            'confirm'          => 1 ,
            'reward_points'    => $rewardPoints,
        );

        $requestUpdate = $this->update($id,$confirm);

        $userData = array(
            'reward_points'    => $rewardPoints,
        );

        $user = $this->userRepo->findById($request->user_id);

        if($user->reward_points == null){
            $userPoints = $this->userRepo->update($user->id,$userData) ;
        }
        else {
            $userData = array(
                'reward_points'    => $rewardPoints + $this->userRepo->findById($request->user_id)->reward_points,
            );
            $userPoints = $this->userRepo->update($user->id,$userData) ;
        }

        $driverData = array(
            'reward_points'    => $rewardPoints,
        );

        $driver = $this->userRepo->findById($request->driver_id);

        if($driver->reward_points == null){
            $driverPoints = $this->userRepo->update($driver->id,$driverData) ;
        }
        else {
            $driverData = array(
                'reward_points'    => $rewardPoints + $this->userRepo->findById($request->driver_id)->reward_points,
            );
            $driverPoints = $this->userRepo->update($driver->id,$driverData) ;
        }

        if(Auth::user()->hasRole('supervisor')){
            $supervisorData = array(
                'reward_points'  => $rewardPoints,
            );

            if(Auth::user()->reward_points == null){
                $supervisorPoints = $this->userRepo->update(Auth::user()->id,$supervisorData) ;
            }
            else {
                $supervisorData = array(
                    'reward_points' => $rewardPoints + $this->userRepo->findById(Auth::user()->id)->reward_points,
                );
                $supervisorPoints = $this->userRepo->update(Auth::user()->id,$supervisorData) ;
            }
        }

        if(Auth::user()->hasRole('supervisor')){

        if($requestUpdate && $userPoints && $driverPoints && $supervisorPoints){
            return true ;
        }
        else {
            return false ;
        }
        }
        else{
            if($requestUpdate && $userPoints && $driverPoints){
                return true ;
            }
            else {
                return false ;
            }
        }

    }



}
