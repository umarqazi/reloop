<?php


namespace App\Repositories\Admin;


use App\Order;
use App\Repositories\Admin\BaseRepo;
use App\Repositories\Admin\UserRepo;
use App\Request;
use App\Services\IOrderStaus;
use App\Services\ISettingKeys;
use App\Services\IUserType;
use App\Setting;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class OrderRepo extends BaseRepo
{
    private $setting ;
    private $request ;
    /**
     * OrderRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Order::class);
        $this->request = new Request();
        $this->setting = new Setting();
    }

    /**
     * @return Mixed
     */
    public function getOrders($city,$district)
    {
        $orders = $this->all()->where('city_id',$city)->where('district_id',$district);
        return $orders;
    }

    /**
     * Method: getOrdersForSupervisor
     *
     * @param $addresses
     *
     * @return int
     */
    public function getOrdersForSupervisor($addresses)
    {
        foreach ($addresses as $address){
            $orders[] = $this->all()->where('city_id',$address->city_id)->where('district_id',$address->district_id);
        }
        $totalOrders = 0;
        foreach ($orders as $order) {
            $totalOrders += count($order);
        }
        return $totalOrders;
    }

    /**
     * Method: redeemedReloopPoints
     *
     * @param null $addresses
     *
     * @return int|mixed
     */
    public function redeemedReloopPoints($addresses = null)
    {
        if($addresses) {
            $redeemedReloopPoints = 0;
            foreach ($addresses as $address) {
                $redeemedReloopPoints += $this->all()->where('city_id', $address->city_id)
                    ->where('district_id', $address->district_id)->sum('redeem_points');
            }
        } else{
            $redeemedReloopPoints = $this->all()->sum('redeem_points');
        }
        return $redeemedReloopPoints;
    }

    /**
     * @param $drivers
     * @param $date
     * @return mixed
     */
    public function availableDrivers($drivers,$date){

        for($i = 0 ; $i < sizeof($drivers) ; $i++){
            $id    = $drivers[$i]->id ;
            $check = $this->checkDriver($id,$date);
            if(!$check){
                $drivers->forget($i);
            }
        }
        return $drivers;
    }

    /**
     * @param $id
     * @param $date
     * @return bool
     */
    public function checkDriver($id,$date){
        $checkOrders = $this->all()->where('driver_id',$id)->where('delivery_date',$date);
        $checkRequests = $this->request->all()->where('driver_id',$id)->where('collection_date',$date)
            ->where('status', '!=', IOrderStaus::ORDER_CANCELLED);
        $max = $this->setting->where('key',ISettingKeys::DRIVER_KEY)->first()->value;
        $count = Count($checkRequests) + Count($checkOrders);

        if($count < $max){
            return true ;
        }
        else{
            return false;
        }
    }

}
