<?php


namespace App\Services\Admin;


use App\Repositories\Admin\UserDonationRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;

class UserDonationService extends BaseService
{

    private $userDonationRepo;

    /**
     * UserDonationService constructor.
     */

    public function __construct()
    {
        $userDonationRepo =  $this->getRepo(UserDonationRepo::class);
        $this->userDonationRepo = new $userDonationRepo;
    }

}
