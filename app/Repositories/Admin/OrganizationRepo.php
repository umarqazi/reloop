<?php


namespace App\Repositories\Admin;


use App\Organization;
use App\Repositories\Admin\BaseRepo;

class OrganizationRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Organization::class);
    }

}
