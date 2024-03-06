<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class AllPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $this->call([
            UserPermissionsSeeder::class,
            CustomersPermissionSeeder::class,
            BooksPermissionSeeder::class,
        ]);
    }
}
