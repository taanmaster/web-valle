<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Spatie\Permission\Models\Permission;

class PermissionSeeder extends Seeder
{
    public function run()
    {
        Permission::create([
            'name' => 'all_access',
        ]);

        Permission::create([
            'name' => 'admin_access',
        ]);

        Permission::create([
            'name' => 'user_access',
        ]);
    }
}
