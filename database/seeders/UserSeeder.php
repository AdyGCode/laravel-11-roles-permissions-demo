<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;
use Spatie\Permission\Models\Role;

class UserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Create admin User and assign the role to him.
        $user = User::create([
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('Password1')
        ]);

        $role = Role::whereName('Admin')->get();
        $user->assignRole([$role]);

        $user = User::create([
            'name' => 'Adrian Gould',
            'email' => 'adrian.gould@nmtafe.wa.edu.au',
            'password' => Hash::make('Password1')
        ]);


        $role = Role::whereName('Admin')->get();
        $user->assignRole([$role]);

    }
}
