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
            'name'     => 'Driver Order Listing',
            'key'      => 'per_day_maximum_orders_for_driver',
            'value'    =>  '4',
        ]);
        Setting::create([
            'name'     => 'Currency Conversion',
            'key'      => 'one_point',
            'value'    => '0.1',
        ]);
        Setting::create([
            'name'     => 'Per Order Reward Points for Drivers and Supervisors',
            'key'      => 'reward_points_per_order_complete',
            'value'    => '10',
        ]);
    }
}
