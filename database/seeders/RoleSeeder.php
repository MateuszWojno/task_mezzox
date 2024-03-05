<?php

namespace Database\Seeders;

use App\Models\Role;
use Illuminate\Database\Seeder;

class RoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {

        $roles = [
            [
                'name'         => 'admin',
                'display_name' => 'Admin',
                'description'  => 'The account with the highest privileges',
            ],
            [
                'name'         => 'user',
                'display_name' => 'User',
                'description'  => 'Regular user with permissions',
            ],
        ];

        foreach ($roles as $role) {
            Role::create($role);
        }


    }
}
