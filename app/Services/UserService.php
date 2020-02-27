<?php


namespace App\Services;


use App\Forms\IForm;
use App\Forms\User\CreateForm;
use App\Forms\User\LoginForm;
use App\Forms\User\PasswordResetForm;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Validation\ValidationException;

/**
 * Class UserService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Feb 24, 2020
 * @project   reloop
 */
class UserService extends BaseService
{
    private $model;
    private $organizationService;
    /**
     * Property: emailNotificationService
     *
     * @var EmailNotificationService
     */
    private $emailNotificationService;

    /**
     * UserService constructor.
     * @param User $model
     * @param OrganizationService $organizationService
     * @param EmailNotificationService $emailNotificationService
     */
    public function __construct(User $model, OrganizationService $organizationService, EmailNotificationService $emailNotificationService)
    {
        $this->model = $model;
        $this->organizationService = $organizationService;
        $this->emailNotificationService = $emailNotificationService;
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        // TODO: Implement findById() method.
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: store
     *
     * @param IForm $form
     *
     * @return User|\Illuminate\Support\MessageBag|mixed
     * @throws ValidationException
     */
    public function store(IForm $form)
    {
        /* @var CreateForm $form */
        if($form->fails())
        {
            return $form->errors();
        }
        $model = $this->model;
        $form->loadToModel($model);
        if ( $form->user_type == IUserType::ORGANIZATION ){

            $organization = $this->organizationService->store($form);
            $model->organization_id = $organization->id;
        } else {

            $model->organization_id = $form->organization_id;
        }
        $model->password = bcrypt($form->password);

        $model->save();

        if ( $form->user_type == IUserType::HOUSE_HOLD ){

            $this->emailNotificationService->userSignUpEmail($model);
        } elseif ($form->user_type == IUserType::ORGANIZATION) {

            $this->emailNotificationService->organizationSignUpEmail($model);
        }
        return $model;
    }

    /**
     * Method: activateAccount
     *
     * @param $id
     * @param $token
     *
     * @return mixed
     */
    public function activateAccount($id, $token)
    {
        $model = $this->model;
        $getUser = $model->where(['id' => $id, 'signup_token' => $token])->first();
        $getUser->status = true;
        $getUser->verified_at = Carbon::now();

        return $getUser->update();
    }

    /**
     * Method: authenticate
     *
     * @param LoginForm $loginForm
     *
     * @return bool|\Illuminate\Contracts\Auth\Authenticatable|null
     */
    public function authenticate(LoginForm $loginForm)
    {
        $loginForm->validate();
        $credentials = [
            'email' => $loginForm->email,
            'password' => $loginForm->password
        ];

        if(Auth::attempt($credentials)) {

            $authUser = auth()->user();
            if ($authUser->status == true) {

                return $authUser;
            }
        }
        return false;
    }

    /**
     * Method: getPasswordResetToken
     *
     * @param PasswordResetForm $resetForm
     *
     * @return bool
     */
    public function getPasswordResetToken(PasswordResetForm $resetForm)
    {
        $resetForm->fails();
        $model = $this->model->where('email', $resetForm->email)->first();
        if(!empty($model) && $model->user_type == IUserType::HOUSE_HOLD){

            $this->emailNotificationService->passwordReset($resetForm->toArray());

            return true;
        }
        return false;
    }
}
