<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        for ($i = 0; $i <= 10; $i++) {
            $user = User::factory()->create([
                'email'      => $i . 'email@example.com',
                'password'   => Hash::make('privateassword'),
                'first_name' => 'Jan',
                'last_name'  => 'Kowalski',
            ]);

            $user->addRole('admin');
        }

        User::factory(10)->create();
    }
}
