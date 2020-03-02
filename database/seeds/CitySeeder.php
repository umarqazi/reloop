<?php

use Illuminate\Database\Seeder;
use App\City;

class CitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        City::create([
        'name'      => 'Dubai',
        ]);
        City::create([
        'name'      => 'Abu Dhabi',
        ]);
        City::create([
        'name'      => 'Al Ain',
        ]);
        City::create([
        'name'      => 'Ajman',
        ]);
        City::create([
        'name'      => 'RAK City',
         ]);
        City::create([
        'name'      => 'Fujairah',
        ]);
        City::create([
        'name'      => 'Umm Al Quwain',
        ]);
        City::create([
        'name'      => 'Khor Fakkan',
        ]);
        City::create([
        'name'      => 'Kalba',
        ]);
        City::create([
        'name'      => 'Jebel Ali',
        ]);
        City::create([
        'name'      => 'Dibba Al-Fujairah',
        ]);
        City::create([
        'name'      => 'Madinat Zayed',
        ]);
        City::create([
        'name'      => 'Ruwais',
        ]);
        City::create([
        'name'      => 'Liwa Oasis',
        ]);
        City::create([
        'name'      => 'Dhaid',
        ]);
        City::create([
        'name'      => 'Ghayathi',
        ]);
        City::create([
        'name'      => 'Ar-Rams',
        ]);
        City::create([
        'name'      => 'Dibba Al-Hisn',
        ]);
        City::create([
        'name'      => 'Hatta',
        ]);
        City::create([
        'name'      => 'Al Madam',
        ]);
    }
}
