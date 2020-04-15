<?php


namespace App\Services;
use App\Forms\IForm;
use App\UserStat;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * Class UserStatService
 *
 * @package   App\Services
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Apr 15, 2020
 * @project   reloop
 */
class UserStatService extends BaseService
{
    /**
     * Property: model
     *
     * @var UserStat
     */
    private $model;

    /**
     * UserStatService constructor.
     * @param UserStat $model
     */
    public function __construct(UserStat $model)
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
     * Method: userStats
     *
     * @param $data
     *
     * @return void
     */
    public function userStats($data)
    {
        $userStats = $this->model->create([
            'user_id'                 => $data->user_id,
            'request_collection_id'   => $data->id,
            'co2_emission_reduced'    => $data->weight * $data->materialCategory->co2_emission_reduced,
            'trees_saved'             => $data->weight * $data->materialCategory->trees_saved,
            'oil_saved'               => $data->weight * $data->materialCategory->oil_saved,
            'electricity_saved'       => $data->weight * $data->materialCategory->electricity_saved,
            'natural_ores_saved'      => $data->weight * $data->materialCategory->natural_ores_saved,
            'water_saved'             => $data->weight * $data->materialCategory->water_saved,
            'landfill_space_saved'    => $data->weight * $data->materialCategory->landfill_space_saved
        ]);
    }

    /**
     * Method: userTotalStats
     *
     * @param $userId
     *
     * @return mixed
     */
    public function userTotalStats($userId)
    {
        $userTotalStats = $this->model->select([
            DB::raw("SUM(co2_emission_reduced) as total_co2_emission_reduced"),
            DB::raw("SUM(trees_saved) as total_trees_saved"),
            DB::raw("SUM(oil_saved) as total_oil_saved"),
            DB::raw("SUM(electricity_saved) as total_electricity_saved"),
            DB::raw("SUM(natural_ores_saved) as total_natural_ores_saved"),
            DB::raw("SUM(water_saved) as total_water_saved"),
            DB::raw("SUM(landfill_space_saved) as total_landfill_space_saved"),
        ])
            ->where('user_id', $userId)->first();
        return $userTotalStats;
    }
}
