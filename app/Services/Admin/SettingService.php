<?php


namespace App\Services\Admin;

use App\Repositories\Admin\SettingRepo;
use App\Services\Admin\BaseService;

class SettingService extends BaseService
{

    private $settingRepo;

    /**
     * SettingService constructor.
     */

    public function __construct()
    {
        $settingRepo       =  $this->getRepo(SettingRepo::class);
        $this->settingRepo = new $settingRepo;
    }


}
