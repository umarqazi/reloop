<?php

use Illuminate\Database\Seeder;
use App\Setting;
class SettingSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Setting::create([
            'keys'      => 'per day maximum orders for driver',
            'values'    =>  '4',
        ]);
        Setting::create([
            'keys'      => '1 AED',
            'values'    => '10 reward points',
        ]);
    }
}
