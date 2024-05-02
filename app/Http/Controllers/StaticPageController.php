<?php

namespace App\Http\Controllers;

use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;


use App\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\Authorize;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Models\Permission;
use Spatie\Permission\Models\Role;

class StaticPageController extends Controller implements HasMiddleware
{
    public static function middleware(): array
    {
        return [
            'role:Member|Super-Admin|Admin',
        ];
    }

    function index(): View
    {
        return view('static.user-home');
    }

    function admin(): View
    {
        $users = User::count();
        $roles = Role::count();
        $perms = Permission::count();
        $products = Product::count();

        /* Recursive is a macro that has been added to the App Service Provider */

        $statistics = collect([
            "Users" => ['data' => $users, 'colour' => 'bg-red-400',],
            "Roles" => ['data' => $roles, 'colour' => 'bg-violet-400',],
            "Perms" => ['data' => $perms, 'colour' => 'bg-sky-400',],
            "Products" => ['data' => $products, 'colour' => 'bg-slate-400',],
        ]);
        return view('static.dashboard', compact(['statistics']));
    }
}
