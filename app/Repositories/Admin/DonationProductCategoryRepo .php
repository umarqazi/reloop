<?php


namespace App\Repositories\Admin;


use App\DonationProductCategory;
use App\Repositories\Admin\BaseRepo;

class DonationProductCategoryRepo extends BaseRepo
{
    /**
     * DonationProductCategoryRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(DonationProductCategory::class);
    }

}
