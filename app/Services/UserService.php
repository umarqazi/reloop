<?php


namespace App\Services;


use App\Forms\IForm;
use App\Forms\User\CreateForm;
use App\Forms\User\LoginForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Order;
use App\User;
use App\UserSubscription;
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
    private $orderService;
    private $requestService;

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
                                OrderService $orderService,
                                RequestService $requestService,
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
        $this->orderService = $orderService;
        $this->requestService = $requestService;
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
     * Method: findByEmail
     * @param $email
     *
     * @return mixed
     */
    public function findByEmail($email)
    {
        return $this->model->where('email', $email)->first();
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
     * Method: updateTripsAfterRequest
     *
     * @param $data
     *
     * @return void
     */
    public function updateTripsAfterRequest($data)
    {
        $model = $this->model->where('id', $data['user_id'])->first();
        $model->trips -= 1;
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
            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $form->errors()
            );
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
                'default'     => true,
            ]
        );

        $stripeCustomerId = $this->stripeService->createCustomer($form);

        if($stripeCustomerId){

            $model->stripe_customer_id = $stripeCustomerId;
            $model->save();
            $model->load('organization','addresses');

            DB::commit();

            if ( $form->user_type == IUserType::HOUSE_HOLD ){

                $signUpSuccess = Config::get('constants.USER_CREATION_SUCCESS');
                $this->emailNotificationService->userSignUpEmail($model);
            } elseif ($form->user_type == IUserType::ORGANIZATION) {

                $signUpSuccess = Config::get('constants.ORGANIZATION_CREATION_SUCCESS');
                $this->emailNotificationService->organizationSignUpEmail($model);
            }

        } else {

            DB::rollback();
        }
        return ResponseHelper::responseData(
            $signUpSuccess,
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $model
        );
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
        if($getUser){

            $getUser->status = true;
            $getUser->verified_at = Carbon::now();
            $getUser->signup_token = null;

            return $getUser->update();
        }
        return false;
    }

    public function userProfile()
    {
        $userProfile = $this->model->with('addresses', 'organization')->where('id', auth()->id())->first();
        if($userProfile){

            return ResponseHelper::responseData(
                Config::get('constants.USER_PROFILE'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                $userProfile
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }

    /**
     * Method: authenticate
     *
     * @param IForm $loginForm
     *
     * @return array
     */
    public function authenticate(IForm $loginForm)
    {
        /* @var LoginForm $loginForm */
        if($loginForm->fails())
        {
            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $loginForm->errors()
            );
        }
        if($loginForm->login_type == ILoginType::APP_LOGIN) {
            $credentials = [
                'email' => $loginForm->email,
                'password' => $loginForm->password
            ];

            if (Auth::attempt($credentials)) {

                $authUser = auth()->user();
                if ($authUser->status == true) {

                    $userProfile = $this->model->where('id', auth()->id())->with('addresses', 'organization', 'roles')->first();
                    return ResponseHelper::responseData(
                        Config::get('constants.USER_LOGIN_SUCCESSFULLY'),
                        IResponseHelperInterface::SUCCESS_RESPONSE,
                        true,
                        $userProfile
                    );
                } else {

                    return ResponseHelper::responseData(
                        Config::get('constants.INVALID_OPERATION'),
                        IResponseHelperInterface::FAIL_RESPONSE,
                        false,
                        [
                            "email_not_verified" => [
                                Config::get('constants.USER_LOGIN_FAILED')
                            ]
                        ]
                    );
                }
            }
            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                [
                    "credentials" => [
                        Config::get('constants.INVALID_CREDENTIALS')
                    ]
                ]
            );
        } else {

            $authUser = $this->findByEmail($loginForm->email);
            if($authUser && $authUser->login_type != ILoginType::APP_LOGIN){

                $authUser = $authUser->load('addresses', 'organization', 'roles');
                return ResponseHelper::responseData(
                    Config::get('constants.USER_LOGIN_SUCCESSFULLY'),
                    IResponseHelperInterface::SUCCESS_RESPONSE,
                    true,
                    $authUser
                );
            } else {

                $stripeCustomerId = $this->stripeService->createCustomer($loginForm);
                if($stripeCustomerId) {

                    $model = $this->model;
                    $loginForm->loadToModel($model);
                    $model->assignRole('user');
                    $model->stripe_customer_id = $stripeCustomerId;
                    $model->login_type = intval($loginForm->login_type);
                    $model->save();
                    $model->load('organization', 'addresses');

                    return ResponseHelper::responseData(
                        Config::get('constants.USER_LOGIN_SUCCESSFULLY'),
                        IResponseHelperInterface::SUCCESS_RESPONSE,
                        true,
                        $model
                    );
                }
            }
        }
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
            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $forgotForm->errors()
            );
        }
        $model = $this->model->where('email', $forgotForm->email)->first();
        if(!empty($model) && $model->user_type == IUserType::HOUSE_HOLD)
        {
            $domain = env('APP_URL');
            $resetToken = str_random(30).strtotime('now');
            $resetUrl = $domain.'://reset_password?token='.$resetToken;
            $data = [
                'resetUrl'   => $resetUrl,
                'email' => $forgotForm->email
            ];
            $this->emailNotificationService->passwordReset($data);
            $model->password_reset_token = $resetToken;
            $model->update();

            return ResponseHelper::responseData(
                Config::get('constants.CHANGE_PASSWORD_SUCCESS_EMAIL'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                [
                    "ResetEmail" => [
                        Config::get('constants.PASSWORD_RESET_EMAIL_SENT')
                    ]
                ]
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            [
                "ResetEmail" => [
                    Config::get('constants.PASSWORD_RESET_EMAIL_NOT_SENT')
                ]
            ]
        );
    }

    /**
     * Method: resetPassword
     *
     * @param IForm $passwordResetForm
     *
     * @return array
     */
    public function resetPassword(IForm $passwordResetForm)
    {
        if($passwordResetForm->fails())
        {
            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $passwordResetForm->errors()
            );
        }
        $model = $this->model->where('password_reset_token', $passwordResetForm->reset_token)->first();
        if(!empty($model) && $model->user_type == IUserType::HOUSE_HOLD)
        {

            $model->password = Hash::make($passwordResetForm->new_password);
            $model->password_reset_token = null;
            $model->update();

            return ResponseHelper::responseData(
                Config::get('constants.PASSWORD_RESET_SUCCESS'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                [
                    "ResetPassword" => [
                        Config::get('constants.PASSWORD_RESET_SUCCESS')
                    ]
                ]
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.INVALID_OPERATION'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            [
                "invalidToken" => [
                    Config::get('constants.INVALID_RESET_TOKEN')
                ]
            ]
        );
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

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $changePasswordForm->errors()
            );
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

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $updateAddressForm->errors()
            );
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
        $authUser->hh_organization_name = $updateUserProfileForm->hh_organization_name ?? $authUser->hh_organization_name;

        $organization = $this->organizationService->findById($updateUserProfileForm->organization_id);
        if($organization){

            $authUser->organization_id = $updateUserProfileForm->organization_id ?? $authUser->organization_id;
        }
        $authUser->update();

        if($authUser->user_type == IUserType::ORGANIZATION && !empty($authUser->organization_id)){

            $this->organizationService->update($authUser->organization_id, $updateUserProfileForm);
        }

        $userProfile = $this->model->where('id', auth()->id())->with('addresses', 'organization')->first();

        return ResponseHelper::responseData(
            Config::get('constants.PROFILE_UPDATE_SUCCESS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $userProfile
        );
    }

    /**
     * Method: deleteAddress
     *
     * @param IForm $deleteAddressForm
     *
     * @return array
     */
    public function deleteAddress(IForm $deleteAddressForm)
    {
        if($deleteAddressForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $deleteAddressForm->errors()
            );
        }
        $deleteAddress = App::make(AddressService::class)->deleteAddress($deleteAddressForm->address_id);
        return $deleteAddress;
    }

    /**
     * Method: defaultAddress
     *
     * @param IForm $defaultAddressForm
     *
     * @return array
     */
    public function defaultAddress(IForm $defaultAddressForm)
    {
        if($defaultAddressForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $defaultAddressForm->errors()
            );
        }
        $defaultAddress = App::make(AddressService::class)->defaultAddress($defaultAddressForm->address_id);
        return $defaultAddress;
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

    /**
     * Method: userBillings
     *
     * @return array
     */
    public function userBillings()
    {
        $userBillings = App::make(TransactionService::class)->userBillings(auth()->id());
        $userSubscriptionsList = [];
        $userOrdersList = [];

        foreach ($userBillings as $userBilling){

            if(empty($userBilling->transactionable_type && $userBilling->transactionable_id)) {
                $userSubscriptionsList[] = [

                    'total'      => $userBilling->total,
                    'created_at' => $userBilling->created_at->toDateTimeString(),
                ];
            } elseif ($userBilling->transactionable_type == UserSubscription::class){

                $userSubscriptions = $this->userSubscriptionService->userSubscriptionsBilling($userBilling->transactionable_id);
                if($userSubscriptions){

                    $userSubscriptionsList[] = [
                        'subscription_number' => $userSubscriptions->subscription_number,
                        'subscription_type'   => $userSubscriptions->subscription_type,
                        'status'              => $userSubscriptions->status,
                        'created_at'          => $userSubscriptions->created_at->toDateTimeString(),
                        'name'                => $userSubscriptions->subscription->name,
                        'trips'               => $userSubscriptions->subscription->request_allowed,
                        'total'               => $userSubscriptions->subscription->price,
                    ];
                }
            } elseif ($userBilling->transactionable_type == Order::class){

                $userOrders = App::make(OrderService::class)->userOrdersList($userBilling->transactionable_id);
                $userOrdersList[] = $userOrders;
            }
        }
        $data = [
            'userSubscriptionsList' => $userSubscriptionsList,
            'userOrdersList' => $userOrdersList,
        ];
        return ResponseHelper::responseData(
            Config::get('constants.BILLING_HISTORY_SUCCESS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $data
        );
    }

    /**
     * Method: driverAssignedTrips
     *
     * @param $assignedOrderForm
     *
     * @return array
     */
    public function driverAssignedTrips($assignedOrderForm)
    {
        $assignedOrders = $this->orderService->assignedOrders(auth()->id(), $assignedOrderForm->date);
        $assignedRequests = $this->requestService->assignedRequests(auth()->id(), $assignedOrderForm->date);

        $data = [
            'assignedOrders'   => $assignedOrders,
            'assignedRequests' => $assignedRequests,
        ];
        return ResponseHelper::responseData(
            Config::get('constants.ASSIGNED_ORDER_LIST'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $data
        );
    }

    /**
     * Method: redeemPoints
     *
     * @param IForm $redeemPointForm
     *
     * @return array
     */
    public function redeemPoints(IForm $redeemPointForm)
    {
        if($redeemPointForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $redeemPointForm->errors()
            );
        }
        $authUser = $this->findById(auth()->id());
        if($authUser){

            if($authUser->reward_points >= $redeemPointForm->redeem_points){

                $pointsConversion = App::make(SettingService::class)->findByKey(ISettingKeys::ONE_POINT);
                if($pointsConversion){

                    $discount = $redeemPointForm->redeem_points * $pointsConversion->value;

                    return ResponseHelper::responseData(
                        Config::get('constants.POINTS_DISCOUNT'),
                        IResponseHelperInterface::SUCCESS_RESPONSE,
                        true,
                        [
                            "discount" => $discount
                        ]
                    );
                }
            } else {

                return ResponseHelper::responseData(
                    Config::get('constants.INVALID_OPERATION'),
                    IResponseHelperInterface::FAIL_RESPONSE,
                    false,
                    null
                );
            }
        }
    }

    /**
     * Method: currencyConversion
     *
     * @return array
     */
    public function currencyConversion()
    {
        $currencyConversion = App::make(SettingService::class)->findByKey(ISettingKeys::ONE_POINT);
        $authUser = $this->findById(auth()->id());

        return ResponseHelper::responseData(
            Config::get('constants.POINTS_DISCOUNT'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            [
                "discount" => floatval($currencyConversion->value),
                "rewardPoints" => $authUser->reward_points ? $authUser->reward_points : 0
            ]
        );
    }
}
