<?php

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;

class RoleAndPermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $roles = [
            'admin',
            'supervisor',
            'user'
        ];

        foreach ($roles as $role){
            Role::create(['name' => $role]);
        }
    }
}
