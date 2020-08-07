<?php


namespace App\Repositories\Admin;


use App\Order;
use App\Repositories\Admin\BaseRepo;
use App\Repositories\Admin\UserRepo;
use App\Request;
use App\Services\IOrderStaus;
use App\Services\ISettingKeys;
use App\Services\IUserType;
use App\Services\UserService;
use App\Setting;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class CollectionRequestRepo extends BaseRepo
{
    private $order ;
    private $setting ;
    /**
     * OrderRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Request::class);
        $this->order = new Order();
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
     * Method: totalAwardedPoints
     *
     * @param null $addresses
     *
     * @return int|mixed
     */
    public function totalAwardedPoints($addresses = null)
    {
        if($addresses) {
            $totalAwardedPoints = 0;
            foreach ($addresses as $address) {
                $totalAwardedPoints += $this->all()->where('city_id', $address->city_id)
                    ->where('district_id', $address->district_id)->sum('reward_points');
            }
        } else{
            $totalAwardedPoints = $this->all()->sum('reward_points');
        }
        return $totalAwardedPoints;
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
        $checkRequests = $this->all()->where('driver_id',$id)->where('collection_date',$date)
            ->where('status', '!=', IOrderStaus::ORDER_CANCELLED);
        $checkOrders = $this->order->all()->where('driver_id',$id)->where('delivery_date',$date) ;
        $max = $this->setting->where('key',ISettingKeys::DRIVER_KEY)->first()->value;
        $count = Count($checkRequests) + Count($checkOrders);
        if($count < $max){
            return true ;
        }
        else{
            return false;
        }
    }

    /**
     * Method: calculateTripsWeights
     *
     * @param $userId
     *
     * @return mixed
     */
    public function calculateTripsWeights($userId)
    {
        return $this->all()->where('user_id', $userId)->where( 'confirm', 1)->load('requestCollection');
    }

    /**
     * Method: calculateHouseholdsTripsWeights
     *
     * @param $orgUserId
     *
     * @return mixed
     */
    public function calculateHouseholdsTripsWeights($orgUserId)
    {
        $user = App::make(UserService::class)->findById($orgUserId);
        $organizationUserIds = $user->organization->users()->where('user_type', 1)->pluck('id')->toArray();
        return $this->all()->whereIn('user_id', $organizationUserIds)
            ->where( 'confirm', 1)->load('requestCollection');
    }

}
