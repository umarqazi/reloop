<?php


namespace App\Services;

use App\Repositories\Admin\OrderAcceptanceRepo;
use App\Services\Admin\BaseService;

class OrderAcceptanceService extends BaseService
{

    private $orderAcceptanceRepo;

    /**
     * OrderAcceptanceService constructor.
     */

    public function __construct()
    {
        $orderAcceptanceRepo       =  $this->getRepo(OrderAcceptanceRepo::class);
        $this->orderAcceptanceRepo = new $orderAcceptanceRepo;
    }


}
