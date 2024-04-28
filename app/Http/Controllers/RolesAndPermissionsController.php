<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Auth\Middleware\Authorize;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\Routing\Controllers\Middleware;
use Illuminate\Support\Facades\Gate;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Models\Role;

class RolesAndPermissionsController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            // examples with aliases, pipe-separated names, guards, etc:
            'role:Super-Admin|Admin',
//            new Middleware('role:author', only: ['index']),
//            new Middleware(RoleMiddleware::using('manager'), except: ['show']),
//            new Middleware(PermissionMiddleware::using('delete records,api'),
//                only: ['destroy']),
        ];
    }

    function __construct()
    {
        // ensure admin has recently logged in, so it's not an unattended admin console being used
        $this->middleware('password.confirm');

        // NOTE: These Gate:: definitions should be in an AuthServiceProvider or in a Model Policy, instead of in this Constructor.
        // establish 2 permission rules for checking authorization later in this controller
        Gate::define('can delete admins', function ($user) {
            return $user->hasAnyRole('Super-Admin', 'Admin');
        });
        Gate::define('can delete super-admins', function ($user) {
            return $user->hasRole('Super-Admin');
        });
    }

    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // build the user-selector dropdown array for the view
        $select = new User;
        $select->id = 0;
        $select->name = ' Please select';

        $excludeRoles = [];
        // don't allow super-admins to be deleted unless pass the rule defined earlier
        if (!auth()->user()->can('can delete super-admins')) {
            $excludeRoles[] = 'Super-Admin';
        }

        // build a list of roles for dropdown
        $roles = Role::whereNotIn('name', $excludeRoles) // ALERT: agnostic of guard_name here!
        ->with('users')
            ->get();

        // build a list of users for the dropdown
        $users = User::query()
            ->with('roles')
            ->get();

        return view('admin.roles_editor',
            [
                'roles' => $roles,
                'users' => $users->prepend($select),
                'canEdit' => auth()->user()->can('assign roles'),
                'canDeleteAdmins' => auth()->user()->can('can delete admins'),
                'canDeleteSuperAdmins' => auth()->user()->can('can delete super-admins'),
            ]);
    }


    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        \abort_unless($request->user()->can('assign roles'), '403',
            'You do not have permission to make Role assignments.');

        $rules = [
            'member_id' => 'exists:users,id',
            'role_id' => 'exists:roles,id',
        ];

        $request->validate($rules);

        $member = User::find($request->input('member_id'));
        $role = Role::findById($request->input('role_id'));

        // if member already has the role, flash message and return
        if ($member->hasRole($role)) {
            //optionally flash a session error message
            // flash()->warning('Note: Member already has the selected role. No action taken.');

            return redirect(route('admin.permissions'));
        }

        // do the assignment
        $member->assignRole($role);

        // optionally flash a success message
        // flash()->success($role->name . ' role assigned to ' . $member->name . '.');

        return redirect(route('admin.permissions'))
            ->with('success', 'Role Created/Updated successfully');
    }


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Request $request)
    {
        \abort_unless($request->user()->can('assign roles'), '403',
            'You do not have permission to change Role assignments.');

        $rules = [
            'member_id' => 'exists:users,id',
            'role_id' => 'exists:roles,id',
        ];
        $request->validate($rules);

        $member = User::find($request->input('member_id'));
        $role = Role::findById($request->input('role_id'));

        // cannot remove if doesn't already have it
        if (!$member->hasRole($role)) {
            // flash a session error message
            // flash()->warning('Note: Member does not have the selected role. No action taken.');

            return redirect(route('admin.permissions'));
        }

        // Prevent tampering with admins
        if ($role->name === 'Admin' && $request->user()->cannot('can delete admins')) {
            // flash()->warning('Action could not be taken.');

            return redirect(route('admin.permissions'));
        }
        if ($role->name === 'Super-Admin' && $request->user()->cannot('can delete super-admins')) {
            // flash()->warning('Action could not be taken.');

            return redirect(route('admin.permissions'));
        }

        // do the actual removal.
        $member->removeRole($role);

        // flash()->success($role->name . ' role removed from ' . $member->name . '.');

        return redirect(route('admin.permissions'))
            ->with('success', 'Role deleted successfully');
    }
}
