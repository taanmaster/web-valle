<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use App\Models\User;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;

class FinancialSupportRolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Permission::create([
            'name' => 'financial_support_access',
        ]);

        $role = Role::create([
            'name' => 'financial_support',
        ]);

        $role->givePermissionTo('all_access');
        $role->givePermissionTo('admin_access');
        $role->givePermissionTo('user_access');
        $role->givePermissionTo('financial_support_access');

        $user = User::create([
            'name' => "Presidencia",
            'email' => "presidencia@valle.com",
            'password' => bcrypt('valle12345'),
        ]);
        $user->assignRole('financial_support');
    }
}
