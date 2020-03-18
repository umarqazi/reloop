<?php


namespace App\Services\Supervisor;


use App\Repositories\Supervisor\OrderRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;

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

    /**
     * @return Mixed
     */
    public function getOrders()
    {

    }

}
