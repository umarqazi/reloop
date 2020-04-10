<?php


namespace App\Repositories\Admin;


use App\Order;
use App\Repositories\Admin\BaseRepo;
use App\Repositories\Admin\UserRepo;
use App\Request;
use App\Services\IUserType;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class CollectionRequestRepo extends BaseRepo
{
    /**
     * OrderRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Request::class);
    }

    /**
     * @return Mixed
     */
    public function getOrders($city,$district)
    {
        $orders = $this->all()->where('city',$city)->where('district',$district);
        return $orders;
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
        $check = $this->all()->where('driver_id',$id)->where('delivery_date',$date);
        $count = Count($check);
        if($count < 4){
            return true ;
        }
        else{
            return false;
        }
    }

}
