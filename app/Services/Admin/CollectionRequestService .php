<?php


namespace App\Services\Admin;


use App\Repositories\Admin\CityRepo;
use App\Repositories\Admin\CollectionRequestRepo;
use App\Repositories\Admin\DistrictRepo;
use App\Repositories\Admin\UserRepo;
use App\Repositories\Admin\OrderRepo;
use App\Services\Admin\BaseService;
use App\Services\EmailNotificationService;
use App\Services\IOrderStaus;
use App\Services\IUserType;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Parent_;

class CollectionRequestService extends BaseService
{

    private $collectionRequestRepo;
    private $userRepo;
    private $cityRepo;
    private $districtRepo;
    private $emailNotificationService;

    /**
     * CollectionRequestService constructor.
     */

    public function __construct(UserRepo $userRepo,CityRepo $cityRepo,DistrictRepo $districtRepo,EmailNotificationService $emailNotificationService)
    {
        $collectionRequestRepo          =  $this->getRepo(CollectionRequestRepo::class);
        $this->collectionRequestRepo                = new $collectionRequestRepo;
        $this->userRepo                 = $userRepo;
        $this->cityRepo                 = $cityRepo;
        $this->districtRepo             = $districtRepo;
        $this->emailNotificationService = $emailNotificationService;
    }

    /**
     * @return Mixed
     */
    public function getOrders($city,$district)
    {
        $orders = $this->orderRepo->getOrders($city,$district);
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
            'delivery_date'    => $request['delivery_date'],
            'status'           => IOrderStaus::ASSIGNED,
        );

        $orderAssignment =  parent::update($id, $order);

        $order = $this->findById($id);

        if($orderAssignment){
            $user = array(
                'email'   => $this->userRepo->findById($order->user_id)->email,
            );

            $this->emailNotificationService->userOrderAssignedEmail($user);

            $driver = array(
                'email'   => $this->userRepo->findById($order->driver_id)->email,
            );

            $this->emailNotificationService->driverOrderAssignedEmail($driver);

            $admin = array(
                'user'   => $this->userRepo->findById($order->user_id)->email,
                'driver' => $this->userRepo->findById($order->driver_id)->email
            );

            $this->emailNotificationService->adminOrderAssignmentNotification($admin);

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
        $order = $this->findById($order_id);

        $city = $order->city ;
        $district = $order->district;

        $city_id = $this->cityRepo->findByName($city)->id ;
        $district_id = $this->districtRepo->findByName($district)->id;

        $drivers = $this->userRepo->getDrivers(IUserType::DRIVER,$city_id,$district_id);

        $availableDrivers = $this->orderRepo->availableDrivers($drivers,$date);

        return $availableDrivers;
    }

}
