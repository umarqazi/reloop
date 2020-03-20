<?php


namespace App\Repositories\Supervisor;


use App\Order;
use App\Repositories\Admin\BaseRepo;
use App\Repositories\Admin\UserRepo;
use App\Services\IUserType;
use Illuminate\Support\Facades\Auth;
use PHPUnit\Framework\Constraint\Count;

class OrderRepo extends BaseRepo
{
    /**
     * OrderRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Order::class);
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
     * @param $id
     */
    public function availableDrivers($drivers,$date){
       //$drivers = $drivers->toArray();

       for($i = 0 ; $i < sizeof($drivers) ; $i++){
           $id = $drivers[$i] ;
           $check = $this->checkDriver($id,$date);
           if(!$check){
               array_splice($drivers, $i, 1);
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
        $check = $this->all()->where('driver_id',$id)->where('delivery_Date',$date);
        $count = Count($check);
        if($count < 4){
            return true ;
        }
        else{
            return false;
        }
    }

}
