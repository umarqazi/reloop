<?php


namespace App\Repositories\Admin;


use App\Setting;
use App\Repositories\Admin\BaseRepo;

class SettingRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(Setting::class);
    }

}
