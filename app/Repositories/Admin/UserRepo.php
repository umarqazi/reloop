<?php


namespace App\Repositories\Admin;

use App\User;

class UserRepo extends BaseRepo
{
    private $getModel;
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $getModel = $this->getModel(User::class);
        $this->getModel = new $getModel;
    }

    /**
     * @param null $type
     * @param $role
     * @return mixed
     */
    public function getSelected($type)
    {
        return $this->getModel->where('user_type', $type)->get();
    }
}
