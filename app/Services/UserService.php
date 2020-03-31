<?php


namespace App\Services;


use App\Forms\IForm;
use App\Forms\User\CreateForm;
use App\Forms\User\LoginForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
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
    private $emailNotificationService;
    private $userSubscriptionService;

    /**
     * UserService constructor.
     * @param User $model
     * @param OrganizationService $organizationService
     * @param EmailNotificationService $emailNotificationService
     */
    public function __construct(User $model, OrganizationService $organizationService,
                                AddressService $addressService,
                                StripeService $stripeService,
                                UserSubscriptionService $userSubscriptionService,
                                EmailNotificationService $emailNotificationService
    )
    {
        parent::__construct();
        $this->model = $model;
        $this->organizationService = $organizationService;
        $this->emailNotificationService = $emailNotificationService;
        $this->addressService = $addressService;
        $this->userSubscriptionService = $userSubscriptionService;
        $this->stripeService = $stripeService;
    }

    /**
     * @inheritDoc
     */
    public function findById($id)
    {
        return $this->model->find($id);
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
        $model->assignRole('user');

        $this->addressService->storeAddress(
            [
                'user_id'     => $model->id,
                'city_id'     => $form->city_id,
                'district_id' => $form->district_id,
                'location'    => $form->location,
                'latitude'    => $form->latitude ?? null,
                'longitude'   => $form->longitude ?? null,
            ]
        );

        $stripeCustomerId = $this->stripeService->createCustomer($form);

        if($stripeCustomerId){

            $model->stripe_customer_id = $stripeCustomerId;
            $model->save();
            $model->load('organization');

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

    public function userProfile()
    {
        $userProfile = $this->model->with('addresses', 'organization')->where('id', auth()->id())->get();
        if($userProfile){

            $responseData = [
                'message' => Config::get('constants.USER_PROFILE'),
                'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                'status' => true,
                'data' => $userProfile
            ];
            return $responseData;
        }

        $responseData = [
            'message' => Config::get('constants.INVALID_OPERATION'),
            'code' => IResponseHelperInterface::FAIL_RESPONSE,
            'status' => false,
            'data' => null
        ];
        return $responseData;
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

                $userProfile = $this->model->where('id', auth()->id())->with('addresses', 'organization')->first();
                $responseData = [
                    'message' => Config::get('constants.USER_LOGIN_SUCCESSFULLY'),
                    'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                    'status' => true,
                    'data' => $userProfile
                ];
                return $responseData;
            } else {

                $responseData = [
                    'message' => Config::get('constants.INVALID_OPERATION'),
                    'code' => IResponseHelperInterface::FAIL_RESPONSE,
                    'status' => false,
                    'data' => [
                        "email_not_verified" => [
                            Config::get('constants.USER_LOGIN_FAILED')
                        ]
                    ]
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
    public function forgotPassword(IForm $forgotForm)
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

    /**
     * Method: changePassword
     *
     * @param IForm $changePasswordForm
     *
     * @return array
     */
    public function changePassword(IForm $changePasswordForm)
    {
        if($changePasswordForm->fails()){

            $responseData = [
                'message' => Config::get('constants.INVALID_OPERATION'),
                'code' => IResponseHelperInterface::FAIL_RESPONSE,
                'status' => false,
                'data' => $changePasswordForm->errors()
            ];
            return $responseData;
        }
        $authUser = auth()->user();
        if (Hash::check($changePasswordForm->old_password, $authUser->password)) {

            $getUser = $this->model->where('id', $authUser->id)->first();
            $getUser->password = Hash::make($changePasswordForm->new_password);
            $getUser->update();

            $successMessage = [
                "password_changed" => [
                    Config::get('constants.CHANGE_PASSWORD_SUCCESS')
                ]
            ];

            $responseData = [
                'message' => Config::get('constants.CHANGE_PASSWORD_SUCCESS'),
                'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                'status' => true,
                'data' => $successMessage
            ];

        } else {

            $errorMessage = [
                "old_password" => [
                    Config::get('constants.OLD_PASSWORD_WRONG')
                ]
            ];

            $responseData = [
                'message' => Config::get('constants.INVALID_OPERATION'),
                'code' => IResponseHelperInterface::FAIL_RESPONSE,
                'status' => false,
                'data' => $errorMessage
            ];
        }
        return $responseData;
    }

    /**
     * Method: updateAddress
     *
     * @param IForm $updateAddressForm
     *
     * @return array
     */
    public function updateAddress(IForm $updateAddressForm)
    {
        if($updateAddressForm->fails()){

            $responseData = [
                'message' => Config::get('constants.INVALID_OPERATION'),
                'code' => IResponseHelperInterface::FAIL_RESPONSE,
                'status' => false,
                'data' => $updateAddressForm->errors()
            ];
            return $responseData;
        } else {

            $data = $updateAddressForm;
            $updateAddress = $this->addressService->updateOrCreate($data);
            return $updateAddress;
        }
    }

    /**
     * Method: updateUserProfile
     *
     * @param IForm $updateUserProfileForm
     * @param $request
     *
     * @return array
     */
    public function updateUserProfile(IForm $updateUserProfileForm, $request)
    {
        $authUser = $this->findById(auth()->id());
        if($request->file()){

            if(!empty($authUser->avatar)){

                Storage::disk()->delete(config('filesystems.profile_pic_upload_path').$authUser->avatar);
            }

            //upload new image
            $fileName = 'Profile-'.strtotime(now()).'.'.$request->file('profile_pic')->getClientOriginalExtension();
            $filePath = config('filesystems.profile_pic_upload_path').$fileName;
            Storage::disk()->put($filePath, file_get_contents($request->file('profile_pic')),'public');

            $authUser->avatar = $fileName ?? $authUser->avatar;
        }

        $authUser->first_name = $updateUserProfileForm->first_name ?? $authUser->first_name;
        $authUser->last_name = $updateUserProfileForm->last_name ?? $authUser->last_name;
        $authUser->phone_number = $updateUserProfileForm->phone_number ?? $authUser->phone_number;

        $organization = $this->organizationService->findById($updateUserProfileForm->organization_id);
        if($organization){

            $authUser->organization_id = $updateUserProfileForm->organization_id ?? $authUser->organization_id;
        }
        $authUser->update();

        if($authUser->user_type == IUserType::ORGANIZATION && !empty($authUser->organization_id)){

            $this->organizationService->update($authUser->organization_id, $updateUserProfileForm);
        }

        $userProfile = $this->model->where('id', auth()->id())->with('addresses', 'organization')->first();

        $responseData = [
            'message' => Config::get('constants.PROFILE_UPDATE_SUCCESS'),
            'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
            'status' => true,
            'data' => $userProfile
        ];
        return $responseData;
    }

    /**
     * Method: getUserPlans
     *
     * @return array
     */
    public function getUserPlans()
    {
        $userPlansData = [];
        $oneTimeServicesData = [];
        $getUserPlans = $this->userSubscriptionService->findByUserId(auth()->id());
        if(!$getUserPlans->isEmpty()) {

            foreach ($getUserPlans as $getUserPlan) {

                $userPlansData[] = [
                    'id' => $getUserPlan->id,
                    'subscription_number' => $getUserPlan->subscription_number,
                    'status' => $getUserPlan->status,
                    'trips' => $getUserPlan->trips,
                    'start_date' => $getUserPlan->start_date,
                    'end_date' => $getUserPlan->end_date,
                    'subscription_type' => $getUserPlan->subscription_type,
                ];
            }
        }
        $oneTimeServices = App::make(ProductService::class)->getProductsByCategoryId(ISubscriptionType::ONETIME);
        if(!$oneTimeServices->isEmpty()) {

            foreach ($oneTimeServices as $oneTimeService) {

                $oneTimeServicesData[] = [
                    'id' => $oneTimeService->id,
                    'name' => $oneTimeService->name,
                    'price' => $oneTimeService->price,
                    'category_type' => $oneTimeService->category_type,
                ];
            }
        }
        $data = [
            'UserPlans' => $userPlansData,
            'OneTimeServices' => $oneTimeServicesData,
        ];
        return ResponseHelper::responseData(
            Config::get('constants.USER_PLANS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $data
        );
    }

    /**
     * Method: userSubscriptions
     * get users subscriptions list
     * @return array
     */
    public function userSubscriptions()
    {
        $userSubscriptions = $this->userSubscriptionService->userSubscriptions(auth()->id());
        if(!$userSubscriptions->isEmpty()){

            return ResponseHelper::responseData(
                Config::get('constants.USER_SUBSCRIPTIONS_SUCCESS'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                $userSubscriptions
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.USER_SUBSCRIPTIONS_FAIL'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }
}
