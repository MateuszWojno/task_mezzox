<?php

namespace Database\Seeders;

use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

abstract class PermissionsBaseSeeder extends Seeder
{
    public $roles;
    public $all = ['admin', 'user'];

    public $staff = ['user'];
    public $admins = ['admin'];

    public function __construct()
    {
        $this->roles = [
            'admin'      => Role::where('name', 'admin')->first(),
            'user'       => Role::where('name', 'user')->first(),
        ];
    }

    /**
     * @param array $roles
     * @param Permission $permission
     */
    protected function setPermissions(array $roles, Permission $permission)
    {
        foreach ($this->roles as $key => $role) {
            if (!in_array($key, $roles)) {
                if ($role->hasPermission($permission->name)) {
                    $role->removePermission($permission->name);
                }
            } elseif (!$role->hasPermission($permission->name)) {
                $role->givePermission($permission->name);
            }
        }
    }
}

