<?php


namespace App\Services\Admin;


use App\Repositories\Admin\DonationProductCategoryRepo;
use App\Services\Admin\BaseService;

class DonationProductCategoryService extends BaseService
{

    private $donationProductCategoryRepo;

    /**
     * DonationProductCategoryService constructor.
     */

    public function __construct()
    {
        $donationProductCategoryRepo         =  $this->getRepo(DonationProductCategoryRepo::class);
        $this->donationProductCategoryRepo   =  new $donationProductCategoryRepo;
    }

}
