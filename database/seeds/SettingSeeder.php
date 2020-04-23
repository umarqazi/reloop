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
            'key'      => 'Driver_Order_Listing',
            'value'    =>  '4',
        ]);
        Setting::create([
            'name'     => 'Currency Conversion',
            'key'      => 'Currency_Conversion',
            'value'    => '0.1',
        ]);
    }
}
