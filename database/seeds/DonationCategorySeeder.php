<?php

use App\DonationProductCategory;
use Illuminate\Database\Seeder;

class DonationCategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DonationProductCategory::create([
            'name'      => 'Plant a Tree',
            'status'    => 1,
        ]);

        DonationProductCategory::create([
            'name'      => 'Charity',
            'status'    => 1,
        ]);
    }
}
