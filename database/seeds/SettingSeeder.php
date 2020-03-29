<?php

use App\Setting;
use Illuminate\Database\Seeder;

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
            'per_day_max_orders_for_drivers'  => 4,
            'points_matrix'                   => 0.0,
        ]);
    }
}
