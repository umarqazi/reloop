<?php

use App\Sector;
use Illuminate\Database\Seeder;

class SectorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $sectors = [
            ['name' => 'Government'],
            ['name' => 'Educational'],
            ['name' => 'HealthCare'],
            ['name' => 'Hospitality'],
            ['name' => 'NGO/Charity'],
            ['name' => 'IT']
        ];

//        Sector::insert($sectors);
        foreach ($sectors as $sector):
            Sector::create($sector);
        endforeach;
    }
}
