<?php

use App\Category;
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
        Category::create([
            'name'      => 'Monthly Subscription',
            'status'    => 1,
            'type'      => 1
        ]);
        Category::create([
            'name'      => 'One Time Service',
            'status'    => 1,
            'type'      => 1
        ]);
        Category::create([
            'name'      => 'Recycling Boxes',
            'status'    => 1,
            'type'      => 2
        ]);
        Category::create([
            'name'      => 'Environmental Products',
            'status'    => 1,
            'type'      => 2
        ]);
    }
}
