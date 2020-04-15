<?php


namespace App\Services\Admin;


use App\Repositories\Admin\PasswordResetRepo;
use App\Repositories\Admin\UserRepo;
use App\Services\Admin\BaseService;
use Illuminate\Support\Facades\Hash;

class PasswordResetService extends BaseService
{

    private $passwordResetRepo;
    private $userRepo;

    /**
     * PasswordResetService constructor.
     */

    public function __construct(UserRepo $userRepo)
    {
        $passwordResetRepo =  $this->getRepo(PasswordResetRepo::class);
        $this->passwordResetRepo = new $passwordResetRepo;
        $this->userRepo  =  $userRepo ;
    }

    public function upgrade($id, $request)
    {
        $userData = array(
            'password'        => Hash::make($request['password']),
        );
        $user_id = $this->findById($id)->user_id ;

        $status = array(
            'status'        => 1,
        );

        $this->update($id,$status);

        return $this->userRepo->update($user_id,$userData);
    }
}
