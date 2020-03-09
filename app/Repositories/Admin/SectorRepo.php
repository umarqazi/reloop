<?php


namespace App\Repositories\Admin;


use App\Sector;
use App\Repositories\Admin\BaseRepo;

class SectorRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Sector::class);
    }

}
