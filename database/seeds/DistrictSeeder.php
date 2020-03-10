<?php

use App\District;
use Illuminate\Database\Seeder;

/**
 * Class DistrictSeeder
 *
 * @author    Faisal Raza <faisal.raza@gems.techverx.com>
 * @copyright 2020 Techverx.com All rights reserved.
 * @since     Mar 09, 2020
 * @project   reloop
 */
class DistrictSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $districts = [
            ['name' => 'England Cluster, International City'],
            ['name' => 'Emirates Hills'],
            ['name' => 'Business Bay'],
            ['name' => 'Mussafah Community'],
            ['name' => 'Al Quoz Industrial Area 2'],
            ['name' => 'Mirdif'],
            ['name' => 'Industrial Area 3'],
            ['name' => 'Al Muraqqabat'],
            ['name' => 'Al Sufouh']
        ];

        foreach ($districts as $district):
            District::create($district);
        endforeach;
    }
}
