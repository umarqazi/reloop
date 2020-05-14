<?php


namespace App\Services\Admin;
use App\Repositories\Admin\EnvironmentalStatsDescriptionRepo;

/**
 * Class EnvironmentalStatsDescriptionService
 *
 * @package   App\Services\Admin
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     May 14, 2020
 * @project   reloop
 */
class EnvironmentalStatsDescriptionService extends BaseService
{
    /**
     * Property: environmentalStatsDescriptionRepo
     *
     * @var mixed
     */
    private $environmentalStatsDescriptionRepo;

    /**
     * EnvironmentalStatsDescriptionService constructor.
     */
    public function __construct()
    {
        $environmentalStatsDescriptionRepo = $this->getRepo(EnvironmentalStatsDescriptionRepo::class);
        $this->environmentalStatsDescriptionRepo = new $environmentalStatsDescriptionRepo;
    }
}
