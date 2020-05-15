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
            ['name' => 'Agriculture and Farming'],
            ['name' => 'Automotive'],
            ['name' => 'Airlines and Airport Operations'],
            ['name' => 'Banking / Finance / Insurance / Accounting'],
            ['name' => 'Consulting / Professional Services / Sustainability'],
            ['name' => 'Education'],
            ['name' => 'Government / Public Service Centres'],
            ['name' => 'NGO / Charity / Religious Organization'],
            ['name' => 'Healthcare / Pharma'],
            ['name' => 'IT / Electronics / Electricals'],
            ['name' => 'Telecommunication'],
            ['name' => 'Online Web Portals / Mobile Apps'],
            ['name' => 'Media / Events / Advertising'],
            ['name' => 'Real Estate / Property Management'],
            ['name' => 'Construction / Architechture'],
            ['name' => 'Waste / Recycling / Facilities Management'],
            ['name' => 'Restaurants / Cafes'],
            ['name' => 'Food and Beverage Manufacturing'],
            ['name' => 'Fashion / Textile'],
            ['name' => 'Personal Care / Cosmetics'],
            ['name' => 'Detergants / Chemicals'],
            ['name' => 'FMCG (Multi-disciplinary)'],
            ['name' => 'Holding Company / Conglomerate'],
            ['name' => 'Hotels / Tourism'],
            ['name' => 'Liesure / Enertainment'],
            ['name' => 'Retail Shops / Shopping Malls'],
            ['name' => 'Logistics / Distribution / Warehousing / Shipping'],
            ['name' => 'Transport'],
            ['name' => 'Sports / Fitness'],
            ['name' => 'Oil and Gas'],
            ['name' => 'Utilities - Electricity / Water / Renewables'],
            ['name' => 'Labour Supply / Accommodations'],
            ['name' => 'Manufacturing - Others'],
            ['name' => 'Others'],
        ];

//        Sector::insert($sectors);
        foreach ($sectors as $sector):
            Sector::create($sector);
        endforeach;
    }
}
