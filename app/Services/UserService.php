<?php


namespace App\Services;


use App\Forms\IForm;
use App\Forms\User\CreateForm;
use App\Forms\User\LoginForm;
use App\Forms\User\PasswordResetForm;
use App\Helpers\IResponseHelperInterface;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
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
    private $addressService;
    private $stripeService;
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
    public function __construct(User $model, OrganizationService $organizationService,
                                AddressService $addressService,
                                StripeService $stripeService,
                                EmailNotificationService $emailNotificationService
    )
    {
        parent::__construct();
        $this->model = $model;
        $this->organizationService = $organizationService;
        $this->emailNotificationService = $emailNotificationService;
        $this->addressService = $addressService;
        $this->stripeService = $stripeService;
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
        DB::beginTransaction();

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

        $this->addressService->storeAddress(
            [
                'user_id' => $model->id,
                'location' => $form->location,
                'city_id' => $form->city_id
            ]
        );

        $stripeCustomerId = $this->stripeService->createCustomer($form);

        if($stripeCustomerId){

            $model->stripe_customer_id = $stripeCustomerId;
            $model->save();

            DB::commit();

            if ( $form->user_type == IUserType::HOUSE_HOLD ){

                $this->emailNotificationService->userSignUpEmail($model);
            } elseif ($form->user_type == IUserType::ORGANIZATION) {

                $this->emailNotificationService->organizationSignUpEmail($model);
            }
            return $model;

        } else {

            DB::rollback();
        }
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
     * @param IForm $loginForm
     *
     * @return bool|\Illuminate\Contracts\Auth\Authenticatable|mixed|null
     */
    public function authenticate(IForm $loginForm)
    {
        if($loginForm->fails())
        {
            $response = [
                'message' => Config::get('constants.INVALID_OPERATION'),
                'code' => IResponseHelperInterface::FAIL_RESPONSE,
                'data' => $loginForm->errors()
            ];
            return $response;
        }
        $credentials = [
            'email' => $loginForm->email,
            'password' => $loginForm->password
        ];

        if(Auth::attempt($credentials)) {

            $authUser = auth()->user();
            if ($authUser->status == true) {

                $response = [
                    'message' => Config::get('constants.USER_LOGIN_SUCCESSFULLY'),
                    'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                    'data' => $authUser
                ];
                return $response;
            }
        }
        return false;
    }

    /**
     * Method: getPasswordResetToken
     *
     * @param IForm $resetForm
     *
     * @return bool|mixed
     */
    public function getPasswordResetToken(IForm $resetForm)
    {
        if($resetForm->fails())
        {
            $response = [
                'message' => Config::get('constants.INVALID_OPERATION'),
                'code' => IResponseHelperInterface::FAIL_RESPONSE,
                'data' => $resetForm->errors()
            ];
            return $response;
        }
        $model = $this->model->where('email', $resetForm->email)->first();
        if(!empty($model) && $model->user_type == IUserType::HOUSE_HOLD){

            $this->emailNotificationService->passwordReset($resetForm->toArray());

            $response = [
                'message' => Config::get('constants.CHANGE_PASSWORD_SUCCESS_EMAIL'),
                'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                'data' => null
            ];
            return $response;
        }
        return false;
    }
}
