<?php


namespace App\Repositories\Admin;


use App\Coupon;
use App\Repositories\Admin\BaseRepo;

class CouponRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Coupon::class);
    }

}
