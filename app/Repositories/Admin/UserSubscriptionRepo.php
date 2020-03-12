<?php


namespace App\Repositories\Admin;


use App\Repositories\Admin\BaseRepo;
use App\UserSubscription;

class UserSubscriptionRepo extends BaseRepo
{
    /**
     * UserSubscriptionRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(UserSubscription::class);
    }

}
