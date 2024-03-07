<?php

namespace Database\Seeders;

use App\Models\Permission;

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

        $borrow = Permission::firstOrCreate([
            'name' => 'books.borrow'
        ], [
            'display_name' => 'Borrow books',
            'description'  => 'Allow admin to borrow the book',
        ]);
        $this->setPermissions($this->all, $borrow);

        $return = Permission::firstOrCreate([
            'name' => 'books.return'
        ], [
            'display_name' => 'Return books',
            'description'  => 'Allow admin to return the book',
        ]);
        $this->setPermissions($this->all, $return);
    }
}
