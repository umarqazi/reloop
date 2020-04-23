<?php

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
         $this->call(RoleAndPermissionSeeder::class);
         $this->call(AdminSeeder::class);
         $this->call(CategorySeeder::class);
         $this->call(CitySeeder::class);
         $this->call(SectorSeeder::class);
         //$this->call(DistrictSeeder::class);
         $this->call(PageSeeder::class);
         $this->call(DonationCategorySeeder::class);
         $this->call(SettingSeeder::class);
    }
}
