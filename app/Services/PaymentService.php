<?php


namespace App\Services;

use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Jobs\SaveOrderDetailsJob;
use App\Jobs\SaveSubscriptionDetailsJob;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;

/**
 * Class PaymentService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 06, 2020
 * @project   reloop
 */
class PaymentService extends BaseService
{
    /**
     * Property: stripeService
     *
     * @var StripeService
     */
    private $stripeService;
    /**
     * Property: order_number
     *
     * @var string
     */
    private $order_number;
    /**
     * Property: productService
     *
     * @var ProductService
     */
    private $productService;

    /**
     * PaymentService constructor.
     */
    public function __construct(StripeService $stripeService, ProductService $productService)
    {
        parent::__construct();
        $this->order_number = 'RE'.strtotime(now());
        $this->stripeService = $stripeService;
        $this->productService = $productService;
    }



    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {

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
     * Method: buyPlan
     *
     * @param $buyPlanForm
     *
     * @return array
     */
    public function buyPlan($buyPlanForm)
    {
        $planDetails = $this->productService->findSubscriptionById($buyPlanForm->subscription_id);
        if(!empty($planDetails)){

            $makePayment = $this->stripeService->buyPlan($buyPlanForm);
            if(array_key_exists('stripe_error', $makePayment)){

                $responseData = [
                    'message' => Config::get('constants.ORDER_FAIL'),
                    'code' => IResponseHelperInterface::FAIL_RESPONSE,
                    'status' => false,
                    'data' => $makePayment['stripe_error']
                ];
                return $responseData;
            } else {

                $data = [
                    'stripe_response' => $makePayment,
                    'product_details' => $planDetails,
                    'user_id' => auth()->id(),
                    'order_number' => $this->order_number
                ];

                SaveSubscriptionDetailsJob::dispatch($data);
                $responseData = [
                    'message' => Config::get('constants.ORDER_SUCCESSFUL'),
                    'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                    'status' => true,
                    'data' => [
                        'buy_plan' => [
                            'Your subscription number is ' . $this->order_number
                        ],
                    ],
                ];
                return $responseData;
            }
        }
    }

    /**
     * Method: buyProduct
     *
     * @param $buyProductForm
     * @param $requestData
     *
     * @return array
     */
    public function buyProduct($buyProductForm, $requestData)
    {
        $productDetails = $this->productService->findProductById($requestData);
        if(!$productDetails->isEmpty()){

            $makePayment = $this->stripeService->buyProduct($buyProductForm);
            if(array_key_exists('stripe_error', $makePayment)){

                $responseData = [
                    'message' => Config::get('constants.ORDER_FAIL'),
                    'code' => IResponseHelperInterface::FAIL_RESPONSE,
                    'status' => false,
                    'data' => $makePayment['stripe_error']
                ];
                return $responseData;


            } else {

                $data = [
                    'stripe_response' => $makePayment,
                    'product_details' => $productDetails,
                    'request_data'    => $requestData,
                    'user_id'         => auth()->id(),
                    'order_number'    => $this->order_number
                ];

                SaveOrderDetailsJob::dispatch($data);
                $responseData = [
                    'message' => Config::get('constants.ORDER_SUCCESSFUL'),
                    'code' => IResponseHelperInterface::SUCCESS_RESPONSE,
                    'status' => true,
                    'data' => [
                        'buy_product' => [
                            'Your order number is ' . $this->order_number
                        ],
                    ],
                ];
                return $responseData;
            }
        }
    }


    /**
     * Method: afterCheckout
     *
     *
     * @param $makePayment
     *
     * @return void
     */
    public function afterCheckout($data)
    {
        $userSubscription = App::make(UserSubscriptionService::class)->create($data);
        $transaction = App::make(TransactionService::class)->buyPlanTransaction($data, $userSubscription);
        $authUser = App::make(UserService::class)->updateTrips($data);
    }

    /**
     * Method: afterBuyProduct
     *
     * @param $data
     *
     * @return void
     */
    public function afterBuyProduct($data)
    {
        if(!empty($data['request_data']['points_discount'])){

            $userService = App::make(UserService::class)->updateRewardPoints($data);
        }
        $orderService = App::make(OrderService::class)->create($data);
        $transaction = App::make(TransactionService::class)->buyProductTransaction($data, $orderService);
        //$orderItemService = App::make(OrderItemService::class)->create($data, $orderService);
    }
}
