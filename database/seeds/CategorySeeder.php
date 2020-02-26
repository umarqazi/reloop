<?php

use App\Categories;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Categories::create([
            'name'      => 'Monthly Subscription',
            'status'    => 1,
            'type'      => 1
        ]);
        Categories::create([
            'name'      => 'One Time Service',
            'status'    => 1,
            'type'      => 1
        ]);
        Categories::create([
            'name'      => 'Recycling Boxes',
            'status'    => 1,
            'type'      => 2
        ]);
        Categories::create([
            'name'      => 'Environmental Products',
            'status'    => 1,
            'type'      => 2
        ]);
    }
}
