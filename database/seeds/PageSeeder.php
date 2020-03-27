<?php

use Illuminate\Database\Seeder;
use App\Page;

class PageSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Page::create([
        'title'      => 'Privacy Policy',
        ]);
        Page::create([
        'title'      => 'Terms and Conditions',
        ]);
        Page::create([
        'title'      => 'About Us',
        ]);
    }
}
