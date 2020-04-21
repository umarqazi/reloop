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
            'keys'      => 'per_day_maximum_orders_for_driver',
            'values'    =>  '4',
        ]);
        Setting::create([
            'keys'      => 'one_AED',
            'values'    => '10',
        ]);
    }
}
