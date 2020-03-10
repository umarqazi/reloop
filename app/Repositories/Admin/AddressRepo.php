<?php


namespace App\Repositories\Admin;


use App\Address;
use App\Repositories\Admin\BaseRepo;

class AddressRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Address::class);
    }

}
