<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class RolesSeeder extends Seeder
{
    public function run()
    {
        // Crear roles si no existen
        $webmaster = Role::firstOrCreate(['name' => 'webmaster']);
        $admin = Role::firstOrCreate(['name' => 'admin']);
        $citizen = Role::firstOrCreate(['name' => 'citizen']);

        // Asignar permisos al rol webmaster
        $webmaster->givePermissionTo('all_access');
        $webmaster->givePermissionTo('admin_access');
        $webmaster->givePermissionTo('user_access');

        // Asignar permisos al rol admin
        $admin->givePermissionTo('admin_access');

        // Asignar permisos al rol citizen
        $citizen->givePermissionTo('user_access');

        // Definir permisos por módulos
        $modules = [
            'dashboard' => [
                'dashboard_view',
            ],
            'transparency' => [
                'transparency_view',
                'transparency_dependencies',
                'transparency_obligations',
                'transparency_files',
            ],
            'financial_support' => [
                'financial_support_view',
                'financial_support_citizens',
                'financial_support_supports',
                'financial_support_reports',
                'financial_support_types',
            ],
            'gazette' => [
                'gazette_view',
                'gazette_municipal',
            ],
            'configuration' => [
                'configuration_view',
                'configuration_users',
                'configuration_legals',
            ],
        ];

        // Crear permisos y asignar a roles
        foreach ($modules as $module => $permissions) {
            foreach ($permissions as $permission) {
                $perm = Permission::firstOrCreate(['name' => $permission]);
                $admin->givePermissionTo($perm);
                $webmaster->givePermissionTo($perm);
            }
        }
    }
}