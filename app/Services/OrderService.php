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
        return $this->model->find($id);
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
            'user_id'             => $data['user_id'],
            'order_number'        => $data['order_number'],
            'subtotal'            => $data['request_data']->subtotal,
            'redeem_points'       => $data['request_data']->points_discount ?? null,
            'coupon_discount'     => $coupon->code ?? null,
            'total'               => $data['request_data']->total,
            'first_name'          => $data['request_data']->first_name ?? null,
            'last_name'           => $data['request_data']->last_name ?? null,
            'organization_name'   => $data['request_data']->organization_name ?? null,
            'email'               => $data['request_data']->email,
            'phone_number'        => $data['request_data']->phone_number,
            'location'            => $data['request_data']->location,
            'latitude'            => $data['request_data']->latitude,
            'longitude'           => $data['request_data']->longitude,
            'city_id'             => $city->id,
            'district_id'         => $district->id
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
            }, 'city', 'district'
        ])->where(['user_id' => auth()->id()])->get();

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
    public function userOrdersList($id)
    {
        return $this->model->with([
            'orderItems' => function ($query){
                return $query->with([
                    'product' => function($subQuery){
                        return $subQuery->select('id', 'name', 'price');
                    }
                ]);
            }, 'city', 'district'
        ])->where(['id' => $id])->first();
    }

    /**
     * Method: assignedOrders
     *
     * @param $driverId
     * @param null $date
     *
     * @return Order[]|\Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function assignedOrders($driverId, $date=null)
    {
        $assignedOrders = $this->model->with([
            'orderItems' => function ($query){
                return $query->with([
                    'product' => function($subQuery){
                        return $subQuery->select('id', 'name');
                    }
                ]);
            }, 'city', 'district'
        ]);
        if(!empty($date)){

            return $assignedOrders->where(['driver_id' => $driverId, 'delivery_date' => $date])->get();
        }
        return $assignedOrders->where('driver_id', $driverId)->get();
    }

    /**
     * Method: updateOrderStatus
     *
     * @param $orderId
     *
     * @return array
     */
    public function updateOrderStatus($orderId, $statusType)
    {
        $findOrder = $this->findById($orderId);
        if($findOrder){

            if($statusType == IOrderStatusType::TRIP_INITIATED){

                $findOrder->status = IOrderStaus::DRIVER_DISPATCHED;
                $findOrder->driver_trip_status = IDriverTripStatus::TRIP_INITIATED;

                App::make(OneSignalNotificationService::class)->oneSignalNotificationService(
                    $findOrder->user_id, Config::get('constants.DRIVER_TRIP_INITIATED'), $findOrder->order_number
                );
            } elseif ($statusType == IOrderStatusType::TRIP_COMPLETED){

                $findOrder->status = IOrderStaus::ORDER_COMPLETED;
                $findOrder->driver_trip_status = IDriverTripStatus::TRIP_COMPLETED;

                // Update Driver Reward Points
                $driver = App::make(UserService::class)->findById($findOrder->driver_id);
                $rewardPointsPerOrder = App::make(SettingService::class)->findByKey(ISettingKeys::REWARD_POINTS_PER_ORDER);
                $driver->reward_points = $driver->reward_points + $rewardPointsPerOrder->value;
                $driver->update();

                // Update Supervisor Reward Points
                if($findOrder->supervisor_id){

                    $supervisor = App::make(UserService::class)->findById($findOrder->supervisor_id);
                    $supervisor->reward_points = $supervisor->reward_points + $rewardPointsPerOrder->value;
                    $supervisor->update();
                }

                App::make(OneSignalNotificationService::class)->oneSignalNotificationService(
                    $findOrder->user_id, Config::get('constants.DRIVER_TRIP_ENDED'), $findOrder->order_number
                );
            }
            $findOrder->update();

            return ResponseHelper::responseData(
                Config::get('constants.TRIP_STATUS_UPDATED'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                null
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.TRIP_INITIATED_FAIL'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }

    /**
     * Method: totalOrders
     *
     * @param $userId
     *
     * @return mixed
     */
    public function totalOrders($userId)
    {
        return $this->model->where('user_id', $userId)->get();
    }

    public function cancelRequest(IForm $cancelRequestForm)
    {
        if($cancelRequestForm->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $cancelRequestForm->errors()
            );
        }

        $findOrder = $this->findById($cancelRequestForm->order_id);
        if($findOrder){

            $findOrder->status = IOrderStaus::ORDER_CANCELLED;
            $findOrder->update();

            $addTrip = true;
            $currentDate = date('Y-m-d');
            $addOneDay = date('Y-m-d', strtotime($currentDate . ' +1 day'));
            if($addOneDay == $findOrder->delivery_date){
                $currentTime = date('H:i:s', strtotime('+3 hours'));
                if($currentTime >= '21:00:00') {
                    $addTrip = false;
                }
            }
            if($addTrip){

            }
            return ResponseHelper::responseData(
                Config::get('constants.CANCEL_REQUEST'),
                IResponseHelperInterface::SUCCESS_RESPONSE,
                true,
                null
            );
        }
        return ResponseHelper::responseData(
            Config::get('constants.INVALID_ORDER_ID'),
            IResponseHelperInterface::FAIL_RESPONSE,
            false,
            null
        );
    }
}
