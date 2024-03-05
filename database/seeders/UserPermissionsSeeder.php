<?php

namespace Database\Seeders;

use App\Models\Permission;

final class UserPermissionsSeeder extends PermissionsBaseSeeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $create = Permission::firstOrCreate([
            'name' => 'users.create'
        ], [
            'display_name' => 'Add user',
            'description'  => 'Allow admin to create the user',
        ]);
        $this->setPermissions($this->admins, $create);

        $read = Permission::firstOrCreate([
            'name' => 'users.read'
        ], [
            'display_name' => 'Display user',
            'description'  => 'Allow admin to display the user',
        ]);
        $this->setPermissions($this->admins, $read);

        $update = Permission::firstOrCreate([
            'name' => 'users.update'
        ], [
            'display_name' => 'Update user',
            'description'  => 'Allow admin to update the user',
        ]);
        $this->setPermissions($this->admins, $update);

        $delete = Permission::firstOrCreate([
            'name' => 'users.delete'
        ], [
            'display_name' => 'Delete user',
            'description'  => 'Allow admin to delete the user',
        ]);
        $this->setPermissions($this->admins, $delete);

    }
}
