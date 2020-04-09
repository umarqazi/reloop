<?php


namespace App\Services\Admin;


use App\Repositories\Admin\ContactUsRepo;
use App\Services\Admin\BaseService;

class ContactUsService extends BaseService
{

    private $contactUsRepo;

    /**
     * ContactUsService constructor.
     */

    public function __construct()
    {
        $contactUsRepo =  $this->getRepo(ContactUsRepo::class);
        $this->contactUsRepo = new $contactUsRepo;
    }

}
