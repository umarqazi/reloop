<?php


namespace App\Repositories\Admin;


use App\Donation;
use App\Repositories\Admin\BaseRepo;

class UserDonationRepo extends BaseRepo
{
    /**
     * UserSubscriptionRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Donation::class);
    }

}
