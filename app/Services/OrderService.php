<?php


namespace App\Services;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\Order;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Validation\ValidationException;

/**
 * Class OrderService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 06, 2020
 * @project   reloop
 */
class OrderService extends BaseService
{

    private $model;
    /**
     * Property: requestService
     *
     * @var RequestService
     */
    private $requestService;

    public function __construct(Order $model, RequestService $requestService)
    {
        parent::__construct();
        $this->model = $model;
        $this->requestService = $requestService;
    }

    /**
     * @inheritDoc
     */
    public function store(IForm $form)
    {
        // TODO: Implement store() method.
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

    public function create($data)
    {
        $city = App::make(CityService::class)->findById($data['request_data']->city_id);
        $district = App::make(DistrictService::class)->findById($data['request_data']->district_id);
        $coupon = App::make(CouponService::class)->findById($data['request_data']->coupon_id);

        $model = $this->model;
        $model = $model->create([
            'user_id'         => $data['user_id'],
            'order_number'    => $data['order_number'],
            'subtotal'        => $data['request_data']->subtotal,
            'redeem_points'   => $data['request_data']->points_discount ?? null,
            'coupon_discount' => $coupon->code ?? null,
            'total'           => $data['request_data']->total,
            'first_name'      => $data['request_data']->first_name,
            'last_name'       => $data['request_data']->last_name,
            'email'           => $data['request_data']->email,
            'phone_number'    => $data['request_data']->phone_number,
            'location'        => $data['request_data']->location,
            'latitude'        => $data['request_data']->latitude,
            'longitude'       => $data['request_data']->longitude,
            'city'            => $city->name,
            'district'        => $district->name
        ]);
        return $model->fresh();
    }

    /**
     * Method: getUserOrders
     *
     * @return array
     */
    public function userOrders()
    {
        $getUserOrders = $this->model->with([
            'orderItems' => function ($query){
                return $query->with([
                    'product' => function($subQuery){
                    return $subQuery->select('id', 'name');
                    }
                ]);
            }
        ])->select('id', 'order_number', 'total', 'status', 'created_at', 'location', 'latitude', 'longitude',
            'city', 'district')
            ->where(['user_id' => auth()->id()])->get();

        $getUserCollectionRequests = $this->requestService->userCollectionRequests();
        $data = [
            'getUserOrders' => $getUserOrders,
            'getUserCollectionRequests' => $getUserCollectionRequests,
        ];

        return ResponseHelper::responseData(
            Config::get('constants.ORDER_HISTORY_SUCCESS'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $data
        );
    }

    /**
     * Method: userOrdersList
     *
     * @return Order|\Illuminate\Database\Eloquent\Builder|\Illuminate\Database\Eloquent\Model|object|null
     */
    public function userOrdersList()
    {
        return $this->model->with([
            'orderItems' => function ($query){
                return $query->with([
                    'product' => function($subQuery){
                        return $subQuery->select('id', 'name');
                    }
                ]);
            }
        ])->select('id', 'order_number', 'total', 'status', 'created_at')
            ->where(['user_id' => auth()->id()])->first();
    }
}
