<?php


namespace App\Services;


use App\Address;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use App\RequestCollection;
use Carbon\Carbon;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Class RequestCollectionService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 25, 2020
 * @project   reloop
 */
class RequestCollectionService extends BaseService
{
    /**
     * Property: model
     *
     * @var RequestCollection
     */
    private $model;
    /**
     * Property: requestService
     *
     * @var RequestService
     */
    private $requestService;

    public function __construct(RequestCollection $model, RequestService $requestService)
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

    /**
     * Method: create
     *
     * @param $data
     * @param $requestId
     *
     * @return void
     */
    public function create($data, $requestId)
    {
        $model = $this->model;
        foreach ($data['material_category_details'] as $material_category){

            $model->create([
                'user_id' => $data['user_id'],
                'request_id' => $requestId,
                'material_category_id' => $material_category->id,
                'category_name' => $material_category->name
            ]);
        }
    }

    /**
     * Method: recordWeight
     *
     * @param IForm $recordWeightCategories
     *
     * @return array
     */
    public function recordWeight(IForm $recordWeightCategories)
    {
        if($recordWeightCategories->fails()){

            return ResponseHelper::responseData(
                Config::get('constants.INVALID_OPERATION'),
                IResponseHelperInterface::FAIL_RESPONSE,
                false,
                $recordWeightCategories->errors()
            );
        }
        foreach ($recordWeightCategories->request_collection as $recordWeightCategory){

            $findCategory = $this->findById($recordWeightCategory['id']);
            if($findCategory){

                $findCategory->weight = $recordWeightCategory['weight'];
                $findCategory->update();
            }
        }
        $findRequest = $this->requestService->findById($recordWeightCategories->request_id);
        if($findRequest){

            $findRequest->driver_trip_status = IDriverTripStatus::RECORD_WEIGHT;
            $findRequest->update();
        }

        if($recordWeightCategories->additional_comments){

            $requestService = App::make(RequestService::class)->additionalComments($recordWeightCategories);
        }

        return ResponseHelper::responseData(
            Config::get('constants.WEIGHT_RECORDED'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            null
        );
    }

    public function getWeightByDate($date)
    {
        return $this->model->whereHas('request', function ($query) use ($date){
            $query->where('collection_date', $date);
        })->sum('weight');
    }

    public function getWeightByWeek($dates)
    {
        return $this->model->whereHas('request', function ($query) use ($dates){
            $query->whereIn('collection_date', $dates)->where('confirm', TRUE);
        })
            ->select(['category_name', DB::raw("SUM(weight) as total_weight")])
            ->groupBy('category_name')->get();
    }

    /**
     * Method: getWeightSum
     * Get weight sum by group of given date.
     *
     * @param $from
     * @param $till
     * @param string $groupBy
     * @param array $users
     *
     * @param int $filterOption
     * @return mixed
     */
    public function getWeightSum(
        $from, $till, $groupBy = '', $users = [],
        int $filterOption = null, int $addressId = null
    ) {
        $result = $this->model->select([
            'requests.collection_date',
            DB::raw('SUM(request_collections.weight) as total_weight')
        ])->join('requests', 'requests.id', 'request_collections.request_id')
            ->where('requests.confirm', true)
            ->whereBetween('requests.collection_date', [$from, $till]);

        if (!empty($users['userId'])) {
            $result->where('requests.user_id', $users['userId']);
        } elseif (!empty($users['organizationId'])) {
            // Organization filter options
            if ($filterOption === IChartFilterOption::ALL) { // For organization+household
                $user = App::make(UserService::class)->findById($users['organizationId']);

                $organizationUserIds = $user->organization->users()->pluck('id')->toArray();

                $result->whereIn('requests.user_id', $organizationUserIds);
            } elseif ($filterOption === IChartFilterOption::HOUSEHOLD) { // For Household
                $user = App::make(UserService::class)->findById($users['organizationId']);
                $organizationUserIds = $user->organization->users()
                    ->where('user_type', '<>', IUserType::ORGANIZATION)
                    ->pluck('id')->toArray();

                $result->whereIn('requests.user_id', $organizationUserIds);
            } elseif ($filterOption === IChartFilterOption::ADDRESS) { // For Household
                /* @var Address $address */
                $address = App::make(AddressService::class)->findById($addressId);

                if (!$address) {
                    abort('404', 'Address not found');
                }

                $result->where('requests.user_id', $users['organizationId'])
                    ->where('city_id', $address->city_id)
                    ->where('district_id', $address->district_id);
            } else { // For organization only
                $result->where('requests.user_id', $users['organizationId']);
            }
        }

        if (!empty($users['driverId'])) {
            $result->where('requests.driver_id', $users['driverId']);
        }

        if (!empty($users['supervisorId'])) {
            $result->where('requests.supervisor_id', $users['supervisorId']);
        }

        return $result->groupBy(DB::raw("$groupBy(requests.collection_date)"))
            ->get()->pluck('total_weight', 'collection_date');
    }

    /**
     * Method: getWeightSumByCat
     * Get weight sum by category of given date
     *
     * @param $from
     * @param $till
     *
     * @return mixed
     */
    public function getWeightSumByCat(
        $from, $till, $users = [],
        int $filterOption = null, int $addressId = null
    ) {
        return $this->model->whereHas(
            'request',
            static function ($query) use ($from, $till, $users, $addressId, $filterOption) {
                $query->whereBetween('collection_date', [$from, $till])
                    ->where('confirm', true);

                if (!empty($users['userId'])) {
                    $query->where('requests.user_id', $users['userId']);
                } elseif (!empty($users['organizationId'])) {
                    // Organization filter options
                    if ($filterOption === IChartFilterOption::ALL) { // For organization+household
                        $user = App::make(UserService::class)->findById($users['organizationId']);
                        $organizationUserIds = $user->organization->users()->pluck('id')->toArray();

                        $query->whereIn('requests.user_id', $organizationUserIds);
                    } elseif ($filterOption === IChartFilterOption::HOUSEHOLD) { // For Household
                        $user = App::make(UserService::class)->findById($users['organizationId']);
                        $organizationUserIds = $user->organization->users()
                            ->where('user_type', '<>', IUserType::ORGANIZATION)
                            ->pluck('id')->toArray();

                        $query->whereIn('requests.user_id', $organizationUserIds);
                    } elseif ($filterOption === IChartFilterOption::ADDRESS) { // For Household
                        /* @var Address $address */
                        $address = App::make(AddressService::class)->findById($addressId);

                        if (!$address) {
                            abort('404', 'Address not found');
                        }

                        $query->where('requests.user_id', $users['organizationId'])
                            ->where('city_id', $address->city_id)
                            ->where('district_id', $address->district_id);
                    } else { // For organization only
                        $query->where('requests.user_id', $users['organizationId']);
                    }

                    $query->where('requests.user_id', $users['organizationId']);
                }

                if (!empty($users['driverId'])) {
                    $query->where('requests.driver_id', $users['driverId']);
                }

                if (!empty($users['supervisorId'])) {
                    $query->where('requests.supervisor_id', $users['supervisorId']);
                }
            }
        )->select(['category_name', DB::raw("SUM(weight) as total_weight")])
            ->groupBy('category_name')
            ->get();
    }

    /**
     * Method: calculateWeight
     *
     * @param null $userId
     *
     * @return mixed
     */
    public function calculateWeight($userId = null)
    {
        if($userId){

            return $this->model->whereHas(
                'request', function ($query){
                return $query->where('confirm', true);
            })->where('user_id', $userId)->sum('weight');
        }
        return $this->model->whereHas(
            'request', function ($query){
            return $query->where('confirm', true);
        })->sum('weight');
    }

    /**
     * Method: calculateHouseholdsWeight
     *
     * @param $userId
     *
     * @return mixed
     */
    public function calculateHouseholdsWeight($userId)
    {
        $user = App::make(UserService::class)->findById($userId);
        $organizationUserIds = $user->organization->users()->where('user_type', 1)->pluck('id')->toArray();
        return $this->model->whereHas(
            'request', function ($query){
            return $query->where('confirm', true);
        })->whereIn('user_id', $organizationUserIds)->sum('weight');
    }
}
