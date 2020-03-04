<?php


namespace App\Repositories\Admin;

use App\RewardPoint;
use App\Repositories\Admin\BaseRepo;

class RewardPointRepo extends BaseRepo
{
    /**
     * RewardPointRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(RewardPoint::class);
    }

}
