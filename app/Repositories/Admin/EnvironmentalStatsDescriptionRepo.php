<?php


namespace App\Repositories\Admin;
use App\EnvironmentalStatsDescription;

/**
 * Class EnvironmentalStatsDescriptionRepo
 *
 * @package   App\Repositories\Admin
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     May 14, 2020
 * @project   reloop
 */
class EnvironmentalStatsDescriptionRepo extends BaseRepo
{
    /**
     * EnvironmentalStatsDescriptionRepo constructor.
     */
    public function __construct()
    {
        $this->getModel(EnvironmentalStatsDescription::class);
    }
}
