<?php


namespace App\Services;
use App\Forms\IForm;
use App\Helpers\IResponseHelperInterface;
use App\Helpers\ResponseHelper;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Config;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Class DashboardService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 15, 2020
 * @project   reloop
 */
class DashboardService extends BaseService
{

    public function __construct()
    {
        parent::__construct();
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

    /**
     * Method: dashboard
     *
     * @return mixed
     */
    public function dashboard()
    {
        $environmentalStats = $this->environmentalStats();
        return $environmentalStats;
    }

    /**
     * Method: environmentalStats
     *
     * @return mixed
     */
    public function environmentalStats()
    {
        $totalEnvironmentalStats = App::make(EnvironmentalStatService::class)->totalStats();
        return $totalEnvironmentalStats;
    }

    /**
     * Method: userDashboard
     *
     * @param $userId
     *
     * @return array
     */
    public function userDashboard($userId)
    {
        $environmentalStats = App::make(EnvironmentalStatService::class)->userEnvironmentalStats($userId);

        $userDashboard = [
            'environmentalStats' => $environmentalStats
        ];

        return ResponseHelper::responseData(
            Config::get('constants.USER_DASHBOARD'),
            IResponseHelperInterface::SUCCESS_RESPONSE,
            true,
            $userDashboard
        );
    }
}
