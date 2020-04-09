<?php


namespace App\Repositories\Admin;


use App\Repositories\Admin\BaseRepo;
use App\ContactUs;
class ContactUsRepo extends BaseRepo
{
    /**
     * ContactUsRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(ContactUs::class);
    }


}
