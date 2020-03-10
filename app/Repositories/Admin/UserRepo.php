<?php


namespace App\Repositories\Admin;

use App\User;
use Illuminate\Support\Collection;

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

    public function all(): Collection
    {
        $users = $this->getModel::whereHas("roles", function($q) {
            $q->where("name", "!=", "admin");
        })->orderBy('email')->get();

        return $users;
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
