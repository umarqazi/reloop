<?php


namespace App\Services;


use App\Repositories\UserRepo;

class UserService extends BaseService
{
    private $userRepo;

    public function __construct()
    {
        $userRepo = $this->getRepo(UserRepo::class);
        $this->userRepo = new $userRepo;
    }

    /**
     * @param $type
     * @param $role
     * @return mixed
     */
    public function getSelected($type)
    {
        return $this->userRepo->getSelected($type);
    }
}
