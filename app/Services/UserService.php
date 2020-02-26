<?php


namespace App\Services;


use App\Repositories\UserRepo;

class UserService extends BaseService
{

    public function __construct()
    {
        $this->getRepo(UserRepo::class);
    }
}
