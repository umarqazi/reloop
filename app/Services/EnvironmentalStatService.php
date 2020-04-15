<?php


namespace App\Services;
use App\EnvironmentalStat;
use App\Forms\IForm;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Class EnvironmentalStatService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 15, 2020
 * @project   reloop
 */
class EnvironmentalStatService extends BaseService
{

    /**
     * Property: model
     *
     * @var EnvironmentalStat
     */
    private $model;

    /**
     * EnvironmentalStatService constructor.
     * @param EnvironmentalStat $model
     */
    public function __construct(EnvironmentalStat $model)
    {
        parent::__construct();
        $this->model = $model;
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
     * Method: findByUserId
     *
     * @param $userId
     *
     * @return mixed
     */
    public function findByUserId($userId)
    {
        return $this->model->where('user_id', $userId)->first();
    }

    /**
     * @inheritDoc
     */
    public function remove($id)
    {
        // TODO: Implement remove() method.
    }

    /**
     * Method: environmentalStats
     *
     * @param $userId
     * @param $data
     *
     * @return void
     */
    public function environmentalStats($userId, $data)
    {
        $findUser = $this->findByUserId($userId);
        if($findUser) {

            $findUser->co2_emission_reduced    = $data->total_co2_emission_reduced;
            $findUser->trees_saved             = $data->total_trees_saved;
            $findUser->oil_saved               = $data->total_oil_saved;
            $findUser->electricity_saved       = $data->total_electricity_saved;
            $findUser->natural_ores_saved      = $data->total_natural_ores_saved;
            $findUser->water_saved             = $data->total_water_saved;
            $findUser->landfill_space_saved    = $data->total_landfill_space_saved;
            $findUser->update();
        } else{

            $this->model->create([
                'user_id'                 => $userId,
                'co2_emission_reduced'    => $data->total_co2_emission_reduced,
                'trees_saved'             => $data->total_trees_saved,
                'oil_saved'               => $data->total_oil_saved,
                'electricity_saved'       => $data->total_electricity_saved,
                'natural_ores_saved'      => $data->total_natural_ores_saved,
                'water_saved'             => $data->total_water_saved,
                'landfill_space_saved'    => $data->total_landfill_space_saved,
            ]);
        }
    }

    /**
     * Method: totalStats
     *
     * @return mixed
     */
    public function totalStats()
    {
        $totalStats = $this->model->select([
            DB::raw("SUM(co2_emission_reduced) as total_co2_emission_reduced"),
            DB::raw("SUM(trees_saved) as total_trees_saved"),
            DB::raw("SUM(oil_saved) as total_oil_saved"),
            DB::raw("SUM(electricity_saved) as total_electricity_saved"),
            DB::raw("SUM(natural_ores_saved) as total_natural_ores_saved"),
            DB::raw("SUM(water_saved) as total_water_saved"),
            DB::raw("SUM(landfill_space_saved) as total_landfill_space_saved"),
        ])->first();
        return $totalStats;
    }
}
