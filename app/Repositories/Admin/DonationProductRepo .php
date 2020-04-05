<?php


namespace App\Repositories\Admin;


use App\D;
use App\DonationProduct;
use App\Repositories\Admin\BaseRepo;

class DonationProductRepo extends BaseRepo
{
    /**
     * DonationProduct Repo constructor.
     */
    public function __construct()
    {
        $this->getModel(DonationProduct::class);
    }

}
