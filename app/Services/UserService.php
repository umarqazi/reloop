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
     * Method: updateTrips
     *
     * @param $data
     *
     * @return void
     */
    public function updateTrips($data)
    {
        $model = $this->model->where('id', $data['user_id'])->first();
        $model->trips += $data['product_details']->request_allowed;
        $model->save();
    }

    /**
     * Method: updateRewardPoints
     *
     * @param $data
     *
     * @return void
     */
    public function updateRewardPoints($data)
    {
        $model = $this->model->where('id', $data['user_id'])->first();
        $model->reward_points -= $data['request_data']->points_discount;
        $model->save();
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
            $responseData = [
                'message' => Config::get('constants.INVALID_OPERATION'),
                'code' => IResponseHelperInterface::FAIL_RESPONSE,
                'status' => false,
                'data' => $form->errors()
            ];
            return $responseData;
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

        } else {

            DB::rollback();
        }
        $responseData = [
            'message' => Config::get('constants.USER_CREATION_SUCCESS'),
            'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
            'status' => true,
            'data' => $model
        ];
        return $responseData;
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
        /* @var LoginForm $loginForm */
        if($loginForm->fails())
        {
            $responseData = [
                'message' => Config::get('constants.INVALID_OPERATION'),
                'code' => IResponseHelperInterface::FAIL_RESPONSE,
                'status' => false,
                'data' => $loginForm->errors()
            ];
            return $responseData;
        }
        $credentials = [
            'email' => $loginForm->email,
            'password' => $loginForm->password
        ];

        if(Auth::attempt($credentials)) {

            $authUser = auth()->user();
            if ($authUser->status == true) {

                $responseData = [
                    'message' => Config::get('constants.USER_LOGIN_SUCCESSFULLY'),
                    'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                    'status' => true,
                    'data' => $authUser
                ];
                return $responseData;
            }
        }
        $errorMessage = [
            "credentials" => [
                Config::get('constants.INVALID_CREDENTIALS')
            ]
        ];
        $responseData = [
            'message' => Config::get('constants.INVALID_OPERATION'),
            'code' => IResponseHelperInterface::FAIL_RESPONSE,
            'status' => false,
            'data' => $errorMessage
        ];
        return $responseData;
    }

    /**
     * Method: getPasswordForgotToken
     *
     * @param IForm $forgotForm
     *
     * @return array
     */
    public function getPasswordForgotToken(IForm $forgotForm)
    {
        if($forgotForm->fails())
        {
            $responseData = [
                'message' => Config::get('constants.INVALID_OPERATION'),
                'code' => IResponseHelperInterface::FAIL_RESPONSE,
                'status' => false,
                'data' => $forgotForm->errors()
            ];
            return $responseData;
        }
        $model = $this->model->where('email', $forgotForm->email)->first();
        if(!empty($model) && $model->user_type == IUserType::HOUSE_HOLD)
        {
            $this->emailNotificationService->passwordReset($forgotForm->toArray());

            $successMessage = [
                "ResetEmail" => [
                    Config::get('constants.PASSWORD_RESET_EMAIL_SENT')
                ]
            ];

            $responseData = [
                'message' => Config::get('constants.CHANGE_PASSWORD_SUCCESS_EMAIL'),
                'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                'status' => true,
                'data' => $successMessage
            ];
            return $responseData;
        }
        $errorMessage = [
            "ResetEmail" => [
                Config::get('constants.PASSWORD_RESET_EMAIL_NOT_SENT')
            ]
        ];
        $responseData = [
            'message' => Config::get('constants.INVALID_OPERATION'),
            'code' => IResponseHelperInterface::FAIL_RESPONSE,
            'status' => false,
            'data' => $errorMessage
        ];
        return $responseData;
    }
}
