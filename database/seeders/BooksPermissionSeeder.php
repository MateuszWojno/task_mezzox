<?php

namespace Database\Seeders;

use App\Models\Permission;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BooksPermissionSeeder extends PermissionsBaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $create = Permission::firstOrCreate([
            'name' => 'books.create'
        ], [
            'display_name' => 'Add book',
            'description'  => 'Allow admin to add the book',
        ]);
        $this->setPermissions($this->all, $create);

        $read = Permission::firstOrCreate([
            'name' => 'books.read'
        ], [
            'display_name' => 'Display book',
            'description'  => 'Allow admin to display the book',
        ]);
        $this->setPermissions($this->all, $read);


        $delete = Permission::firstOrCreate([
            'name' => 'books.delete'
        ], [
            'display_name' => 'Delete book',
            'description'  => 'Allow admin to delete the book',
        ]);
        $this->setPermissions($this->admins, $delete);

        $search = Permission::firstOrCreate([
            'name' => 'books.search'
        ], [
            'display_name' => 'Search books',
            'description'  => 'Allow admin to search the book',
        ]);
        $this->setPermissions($this->all, $search);
    }
}
