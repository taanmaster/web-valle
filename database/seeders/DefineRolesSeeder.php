<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class DefineRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Crear roles
        $roles = [
            'dashboard',
            'transparency',
            'financial_support',
            'private_secretary',
            'gazette',
            'configuration',
            'environment',
            'all',
        ];

        // Crear permiso admin_access
        $adminAccessPermission = Permission::firstOrCreate(['name' => 'admin_access']);

        foreach ($roles as $roleName) {
            $role = Role::firstOrCreate(['name' => $roleName]);
            if (! $role->hasPermissionTo('admin_access')) {
                $role->givePermissionTo($adminAccessPermission);
            }
        }
    }
}
