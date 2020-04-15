<?php


namespace App\Repositories\Admin;


use App\PasswordChangeRequest;
use App\Product;
use App\Repositories\Admin\BaseRepo;

class PasswordResetRepo extends BaseRepo
{
    /**
     * PasswordResetRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(PasswordChangeRequest::class);
    }

}
