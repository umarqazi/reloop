<?php


namespace App\Repositories\Admin;


use App\Repositories\BaseRepo;
use App\Subscription;

class SubscriptionRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Subscription::class);
    }

}
