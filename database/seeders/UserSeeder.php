<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\User;

class UserSeeder extends Seeder
{
    public function run()
    {
        $user = User::create([
            'name' => "Webmaster",
            'email' => "webmaster@valle.com",
            'password' => bcrypt('valle12345'),
        ]);
        $user->assignRole('webmaster');

        $user = User::create([
            'name' => "Administrador",
            'email' => "admin@valle.com",
            'password' => bcrypt('valle12345'),
        ]);
        $user->assignRole('admin');

        $user = User::create([
            'name' => "Ciudadano",
            'email' => "ciudadano@valle.com",
            'password' => bcrypt('valle12345'),
        ]);
        $user->assignRole('citizen');
        
    }
}
