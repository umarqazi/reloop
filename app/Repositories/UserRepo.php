<?php


namespace App\Repositories;


use App\User;

class UserRepo extends BaseRepo
{
    /**
     * UserRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(User::class);
    }

    public function getByStatus(int $userId)
    {
        // TODO: Implement getByStatus() method.
    }
}
