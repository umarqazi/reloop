<?php


namespace App\Repositories\Admin;


use App\OrderAcceptance;
use App\Repositories\Admin\BaseRepo;

class OrderAcceptanceRepo extends BaseRepo
{
    /**
     * OrderAcceptanceRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(OrderAcceptance::class);
    }

}
