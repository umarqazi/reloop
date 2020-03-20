<?php


namespace App\Services\Supervisor;


use App\Repositories\Admin\CityRepo;
use App\Repositories\Admin\DistrictRepo;
use App\Repositories\Admin\UserRepo;
use App\Repositories\Supervisor\OrderRepo;
use App\Services\Admin\BaseService;
use App\Services\IOrderStaus;
use App\Services\IUserType;
use Illuminate\Http\Request;
use phpDocumentor\Reflection\Types\Parent_;

class OrderService extends BaseService
{

    private $orderRepo;
    private $userRepo;
    private $cityRepo;
    private $districtRepo;

    /**
     * OrderService constructor.
     */

    public function __construct(UserRepo $userRepo,CityRepo $cityRepo,DistrictRepo $districtRepo)
    {
        $orderRepo =  $this->getRepo(OrderRepo::class);
        $this->orderRepo = new $orderRepo;
        $this->userRepo  = $userRepo;
        $this->cityRepo  = $cityRepo;
        $this->districtRepo = $districtRepo;
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
        return parent::update($id, $order);
    }

    /**
     * @param $id
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
