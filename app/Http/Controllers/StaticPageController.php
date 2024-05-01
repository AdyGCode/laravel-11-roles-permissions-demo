<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Routing\Controllers\HasMiddleware;
use Illuminate\View\View;


use App\Http\Controllers\Controller;
use Illuminate\Auth\Middleware\Authorize;
use Spatie\Permission\Middleware\PermissionMiddleware;
use Spatie\Permission\Middleware\RoleMiddleware;
use Spatie\Permission\Models\Role;

class StaticPageController extends Controller implements HasMiddleware
{
     public static function middleware(): array
    {
        return [
            'role:Member|Super-Admin|Admin',
        ];
    }

    function index():View
    {

        return view('static.user-home');
    }
}
