<?php

namespace Database\Seeders;

use App\Models\Permission;

class CustomersPermissionSeeder extends PermissionsBaseSeeder
{
    /**
     * Run the database seeds.
     */
    public function run()
    {
        $create = Permission::firstOrCreate([
            'name' => 'customers.create'
        ], [
            'display_name' => 'Add customer',
            'description'  => 'Allow admin to add the client',
        ]);
        $this->setPermissions($this->all, $create);

        $read = Permission::firstOrCreate([
            'name' => 'customers.read'
        ], [
            'display_name' => 'Display customer',
            'description'  => 'Allow admin to display the client',
        ]);
        $this->setPermissions($this->all, $read);


        $delete = Permission::firstOrCreate([
            'name' => 'customers.delete'
        ], [
            'display_name' => 'Delete customer',
            'description'  => 'Allow admin to delete the client',
        ]);
        $this->setPermissions($this->admins, $delete);



    }
}
