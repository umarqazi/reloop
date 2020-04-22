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
    public function environmentalStats($totalStats)
    {
        foreach ($totalStats as $totalStat){

            $findUser = $this->findByUserId($totalStat->user_id);
            if($findUser) {

                $findUser->co2_emission_reduced    = $totalStat->total_co2_emission_reduced;
                $findUser->trees_saved             = $totalStat->total_trees_saved;
                $findUser->oil_saved               = $totalStat->total_oil_saved;
                $findUser->electricity_saved       = $totalStat->total_electricity_saved;
                $findUser->natural_ores_saved      = $totalStat->total_natural_ores_saved;
                $findUser->water_saved             = $totalStat->total_water_saved;
                $findUser->landfill_space_saved    = $totalStat->total_landfill_space_saved;
                $findUser->update();
            } else{

                $this->model->create([
                    'user_id'                 => $totalStat->user_id,
                    'co2_emission_reduced'    => $totalStat->total_co2_emission_reduced,
                    'trees_saved'             => $totalStat->total_trees_saved,
                    'oil_saved'               => $totalStat->total_oil_saved,
                    'electricity_saved'       => $totalStat->total_electricity_saved,
                    'natural_ores_saved'      => $totalStat->total_natural_ores_saved,
                    'water_saved'             => $totalStat->total_water_saved,
                    'landfill_space_saved'    => $totalStat->total_landfill_space_saved,
                ]);
            }
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

    /**
     * Method: userEnvironmentalStats
     *
     * @param $userId
     *
     * @return int[]
     */
    public function userEnvironmentalStats($userId)
    {
        $userEnvironmentalStats = $this->model->where('user_id', $userId)->first();
        if($userEnvironmentalStats){

            return $userEnvironmentalStats;
        }
        return [
            'co2_emission_reduced'  => 0,
            'trees_saved'           => 0,
            'oil_saved'             => 0,
            'electricity_saved'     => 0,
            'natural_ores_saved'    => 0,
            'water_saved'           => 0,
            'landfill_space_saved'  => 0,
        ];
    }
}
