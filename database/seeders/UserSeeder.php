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
        // get the Super Admin and Admin roles for the Administrator, Lecturer and Student
        $roleSuperAdmin = Role::whereName('Super-Admin')->get();
        $roleAdmin = Role::whereName('Admin')->get();
        $roleMember = Role::whereName('Member')->get();

        // Create admin User and assign the role to him.
        $userAdmin = User::create([
            'id' => 111,
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => Hash::make('Password1')
        ]);

        $userAdmin->assignRole([$roleSuperAdmin]);

        $userLecturer = User::create([
            'id' => 500,
            'name' => 'Adrian Gould',
            'email' => 'adrian.gould@nmtafe.wa.edu.au',
            'password' => Hash::make('Password1')
        ]);

        $userLecturer->assignRole([$roleSuperAdmin]);

        $userStudent = User::create([
            'id' => 501,
            'name' => 'STUDENT NAME',
            'email' => 'STUDENT.NAME@example.com',
            'password' => Hash::make('Password1')
        ]);
        $userStudent->assignRole([$roleAdmin]);


        $userGuest = User::create([
            'id' => 1000,
            'name' => 'Dee Mouser',
            'email' => 'dee.mouser@example.com',
            'password' => Hash::make('Password1')
        ]);

        $roleGuest = Role::create(['name' => 'Guest']);
        $roleGuest->givePermissionTo('members');
        $roleGuest->givePermissionTo('product-list');
        $roleGuest->givePermissionTo('product-show');
        $userGuest->assignRole([$roleGuest]);
        $userGuest->assignRole([$roleMember]);

    }
}
