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
        $roleGuest = Role::whereName('Guest')->get();

        // Create Super Admin User and assign the role to him.
        $userAdmin = User::create([
            'id' => 111,
            'name' => 'Administrator',
            'email' => 'admin@example.com',
            'password' => 'Password1',
        ]);
        $userAdmin->assignRole([$roleSuperAdmin]);

        // Create Second Super Admin
        $userLecturer = User::create([
            'id' => 500,
            'name' => 'Adrian Gould',
            'email' => 'adrian.gould@example.com',
            'password' => 'Password1',
        ]);
        $userLecturer->assignRole([$roleSuperAdmin]);

        // Create Admin
        $userStudent = User::create([
            'id' => 501,
            'name' => 'STUDENT NAME',
            'email' => 'STUDENT.NAME@example.com',
            'password' => 'Password1',
        ]);
        $userStudent->assignRole([$roleAdmin]);

        // Create Member (verified user)
        $userMember = User::create([
            'id' => 1000,
            'name' => "Cat A'Tonic",
            'email' => 'cat.atonic@example.com',
            'password' => 'Password1',
        ]);
        $userMember->assignRole([$roleMember]);

        // Create Guest (unverified user)
        $userGuest = User::create([
            'id' => 1001,
            'name' => 'Dee Mouser',
            'email' => 'dee.mouser@example.com',
            'password' => 'Password1',
        ]);

        $userGuest->assignRole([$roleGuest]);


        // User::factory(10)->create();

        User::factory()->create([
            'name' => 'Test User',
            'email' => 'test@example.com',
            'password'=>'Password1',
        ]);
    }
}
