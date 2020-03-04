<?php


namespace App\Repositories\Admin;


use App\Product;
use App\RedeemPoint;
use App\Repositories\Admin\BaseRepo;

class RedeemPointRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(RedeemPoint::class);
    }

}
