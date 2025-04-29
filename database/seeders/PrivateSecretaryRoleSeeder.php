<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class PrivateSecretaryRoleSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $permissions = [
            'private_secretary_view',
            'private_secretary_edit',
            'private_secretary_create',
            'private_secretary_delete'
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        $private_secretary = Role::firstOrCreate(['name' => 'private_secretary']);
        $private_secretary->givePermissionTo('private_secretary_view');
        $private_secretary->givePermissionTo('private_secretary_edit');
        $private_secretary->givePermissionTo('private_secretary_create');
        $private_secretary->givePermissionTo('private_secretary_delete');
        $private_secretary->givePermissionTo('admin_access');
        $private_secretary->givePermissionTo('user_access');
    }
}
