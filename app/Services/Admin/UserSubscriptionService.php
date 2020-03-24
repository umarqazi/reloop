<?php


namespace App\Services\Admin;


use App\Repositories\Admin\UserSubscriptionRepo;
use App\Services\Admin\BaseService;
use Illuminate\Http\Request;

class UserSubscriptionService extends BaseService
{

    private $userSubscriptionRepo;

    /**
     * UserSubscriptionService constructor.
     */

    public function __construct()
    {
        $userSubscriptionRepo =  $this->getRepo(UserSubscriptionRepo::class);
        $this->userSubscriptionRepo = new $userSubscriptionRepo;
    }

}
