<?php


namespace App\Repositories\Admin;


use App\Order;
use App\Repositories\Admin\BaseRepo;

class OrderRepo extends BaseRepo
{
    /**
     * OrderRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Order::class);
    }

}
