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
    /**
     * Property: environmentalStatService
     *
     * @var EnvironmentalStatService
     */
    private $environmentalStatService;

    public function __construct(RequestCollection $model,
                                RequestService $requestService,
                                EnvironmentalStatService $environmentalStatService
    ){
        parent::__construct();
        $this->model = $model;
        $this->requestService = $requestService;
        $this->environmentalStatService = $environmentalStatService;
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
        $stats = $this->environmentalStatService->allUsersTotalStats();

        if (!empty($users['userId'])) {
            if ($users['userId'] === 'all') {
                $result->whereHas(
                    'user',
                    static function($user) {
                        $user->where('user_type', IUserType::HOUSE_HOLD);
                    }
                );
                $stats = $this->environmentalStatService->findByUserType(IUserType::HOUSE_HOLD);
            } else {
                $result->where('requests.user_id', $users['userId']);
                $stats = $this->environmentalStatService->userEnvironmentalStats($users['userId']);
            }
        } elseif (!empty($users['organizationId'])) {
            if ($users['organizationId'] === 'all') {
                $result->whereHas(
                    'user',
                    static function($user) {
                        $user->where('user_type', IUserType::ORGANIZATION);
                    }
                );
                $stats = $this->environmentalStatService->findByUserType(IUserType::ORGANIZATION);
            } else {
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
                    $stats = $this->environmentalStatService->userEnvironmentalStats($users['organizationId']);
                }
            }
        }

        if (!empty($users['driverId'])) {
            if ($users['driverId'] === 'all') {
                $result->whereHas(
                    'user',
                    static function($user) {
                        $user->where('user_type', IUserType::DRIVER);
                    }
                );
                $stats = $this->environmentalStatService->findByUserType(IUserType::DRIVER);
            } else {
                $result->where('requests.driver_id', $users['driverId']);
                $stats = $this->environmentalStatService->userEnvironmentalStats($users['driverId']);
            }
        }

        if (!empty($users['supervisorId'])) {
            if ($users['supervisorId'] === 'all') {
                $result->whereHas(
                    'user',
                    static function($user) {
                        $user->where('user_type', IUserType::SUPERVISOR);
                    }
                );
                $stats = $this->environmentalStatService->findByUserType(IUserType::SUPERVISOR);
            } else {
                $result->where('requests.supervisor_id', $users['supervisorId']);
                $stats = $this->environmentalStatService->userEnvironmentalStats($users['supervisorId']);
            }
        }

        return [
            'weight' => $result->groupBy(DB::raw("$groupBy(requests.collection_date)"))
            ->get()->pluck('total_weight', 'collection_date'),
            'stats' => $stats
        ];
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
                    if ($users['userId'] === 'all') {
                        $query->whereHas(
                            'user',
                            static function($user) {
                                $user->where('user_type', IUserType::HOUSE_HOLD);
                            }
                        );
                    } else {
                        $query->where('requests.user_id', $users['userId']);
                    }
                } elseif (!empty($users['organizationId'])) {
                    if ($users['organizationId'] === 'all') {
                        $query->whereHas(
                            'user',
                            static function($user) {
                                $user->where('user_type', IUserType::ORGANIZATION);
                            }
                        );
                    } else {
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
                    }
                }

                if (!empty($users['driverId'])) {
                    if ($users['driverId'] === 'all') {
                        $query->whereHas(
                            'user',
                            static function($user) {
                                $user->where('user_type', IUserType::DRIVER);
                            }
                        );
                    } else {
                        $query->where('requests.driver_id', $users['driverId']);
                    }
                }

                if (!empty($users['supervisorId'])) {
                    if ($users['supervisorId'] === 'all') {
                        $query->whereHas(
                            'user',
                            static function($user) {
                                $user->where('user_type', IUserType::SUPERVISOR);
                            }
                        );
                    } else {
                        $query->where('requests.supervisor_id', $users['supervisorId']);
                    }
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
     * Method: calculateSupervisorWeight
     *
     * @param $cityId
     * @param $districtId
     *
     * @return mixed
     */
    public function calculateSupervisorWeight($addresses)
    {
        foreach ($addresses as $address){

            $cityId = $address->city_id;
            $districtId = $address->district_id;
            $requestWeight[] = $this->model->whereHas(
                'request', function ($query) use ($cityId, $districtId) {
                return $query->where('confirm', true)
                    ->where('city_id', $cityId)
                    ->where('district_id', $districtId);
            })->sum('weight');
        }
        return $requestWeight;
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
