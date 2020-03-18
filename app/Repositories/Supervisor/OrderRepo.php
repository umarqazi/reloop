<?php


namespace App\Repositories\Supervisor;


use App\Order;
use App\Repositories\Admin\BaseRepo;

class OrderRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Order::class);
    }

}
