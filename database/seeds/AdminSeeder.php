<?php

use App\User;
use Illuminate\Database\Seeder;

class AdminSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $user = User::create([
            'first_name'    => 'Admin',
            'email'         => 'admin@reloop.com',
            'phone_number'  => '123456123',
            'password'      => Hash::make('admin@321'),
            'status'        => 1
        ]);
        $user->assignRole('admin');

    }
}
