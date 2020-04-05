<?php


namespace App\Services\Admin;


use App\Repositories\Admin\DonationProductRepo;
use App\Services\Admin\BaseService;

class DonationProductService extends BaseService
{

    private $donationProductRepo;

    /**
     * DonationProductService constructor.
     */

    public function __construct()
    {
        $donationProductRepo         =  $this->getRepo(DonationProductRepo::class);
        $this->donationProductRepo   =  new $donationProductRepo;
    }


}
