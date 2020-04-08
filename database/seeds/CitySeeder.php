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
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Abu Dhabi',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Al Ain',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Ajman',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'RAK City',
        'status'    =>  1,
         ]);
        City::create([
        'name'      => 'Fujairah',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Umm Al Quwain',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Khor Fakkan',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Kalba',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Jebel Ali',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Dibba Al-Fujairah',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Madinat Zayed',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Ruwais',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Liwa Oasis',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Dhaid',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Ghayathi',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Ar-Rams',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Dibba Al-Hisn',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Hatta',
        'status'    =>  1,
        ]);
        City::create([
        'name'      => 'Al Madam',
        'status'    =>  1,
        ]);
    }
}
