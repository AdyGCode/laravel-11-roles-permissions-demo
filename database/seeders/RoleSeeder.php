<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;
use Spatie\Permission\PermissionRegistrar;

class RoleSeeder extends Seeder
{

    private $permissions = [
        'role-assign',    'role-revoke',
        'role-list',      'role-show',      'role-create',     'role-edit',      'role-delete',
        'product-list',   'product-show',   'product-create',  'product-edit',   'product-delete',
        'user-list',      'user-show',      'user-create',     'user-edit',      'user-delete',
        'members',
    ];


    /**
     * Run the database seeds.
     */
    public function run(): void
    {

        // Reset cached roles and permissions
        app()[PermissionRegistrar::class]->forgetCachedPermissions();


        // Create each of the permissions ready for role creation
        foreach ($this->permissions as $permission) {
            Permission::create(['name' => $permission]);
        }

        // Generate the Super-Admin Role
        $roleSuperAdmin = Role::create(['name' => 'Super-Admin']);
        $permissionsAll = Permission::pluck('id', 'id')->all();
        $roleSuperAdmin->syncPermissions($permissionsAll);

        // Generate the Admin Role
        $roleAdmin = Role::create(['name' => 'Admin']);
        $roleAdmin->givePermissionTo('role-assign');
        $roleAdmin->givePermissionTo('role-revoke');
        $roleAdmin->givePermissionTo('product-list');
        $roleAdmin->givePermissionTo('product-show');
        $roleAdmin->givePermissionTo('product-create');
        $roleAdmin->givePermissionTo('product-edit');
        $roleAdmin->givePermissionTo('product-delete');
        $roleAdmin->givePermissionTo('user-list');
        $roleAdmin->givePermissionTo('user-edit');
        $roleAdmin->givePermissionTo('user-show');
        $roleAdmin->givePermissionTo('user-create');
        $roleAdmin->givePermissionTo('user-delete');
        $roleAdmin->givePermissionTo('members');

        // Generate the Member role
        $roleUser = Role::create(['name' => 'Member']);
        $roleUser->givePermissionTo('product-list');
        $roleUser->givePermissionTo('product-edit');
        $roleUser->givePermissionTo('product-show');
        $roleUser->givePermissionTo('product-create');
        $roleUser->givePermissionTo('product-delete');
        $roleUser->givePermissionTo('members');
    }
}
