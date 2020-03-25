<?php


namespace App\Services\Admin;


use App\Repositories\Admin\OrderRepo;
use App\Services\Admin\BaseService;

class OrderService extends BaseService
{

    private $orderRepo;

    /**
     * OrderService constructor.
     */

    public function __construct()
    {
        $orderRepo =  $this->getRepo(OrderRepo::class);
        $this->orderRepo = new $orderRepo;
    }


}
