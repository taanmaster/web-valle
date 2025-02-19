<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        $permissions = [
            'all_access',
            'admin_access',
            'user_access',
            'dashboard_view',
            'transparency_view',
            'transparency_dependencies',
            'transparency_obligations',
            'transparency_files',
            'financial_support_view',
            'financial_support_citizens',
            'financial_support_supports',
            'financial_support_reports',
            'financial_support_types',
            'gazette_view',
            'gazette_municipal',
            'configuration_view',
            'configuration_users',
            'configuration_legals',
        ];

        foreach ($permissions as $permission) {
            Permission::create(['name' => $permission]);
        }
    }
}